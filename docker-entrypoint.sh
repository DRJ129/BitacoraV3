#!/bin/sh
set -e

# Small entrypoint for the app container. Responsibilities:
# - wait for DB availability
# - install npm/composer deps when missing (useful with mounted volumes)
# - run migrations
# - exec the container CMD (php-fpm)

wait_for_db() {
	MAX_TRIES=30
	try=0
		until php -r '
		$host = getenv("DB_HOST") ?: "db";
		$port = getenv("DB_PORT") ?: 3306;
		$user = getenv("DB_USERNAME");
		$pass = getenv("DB_PASSWORD");
		if ((!$user || $user === "") || (!isset($pass) || $pass === "")) {
			$env = @file_get_contents("/var/www/.env");
			if ($env !== false) {
				if ((!$user || $user === "") && preg_match("/^DB_USERNAME=(.*)$/m", $env, $m)) {
					$user = trim($m[1]);
				}
				if ((!isset($pass) || $pass === "") && preg_match("/^DB_PASSWORD=(.*)$/m", $env, $m2)) {
					$pass = trim($m2[1]);
				}
			}
		}
		$user = $user ?: "root";
		$pass = $pass ?? "";
		$conn = @mysqli_connect($host, $user, $pass, null, $port);
		exit($conn ? 0 : 1);
		' 2>/dev/null; do
		try=$((try+1))
		if [ $try -ge $MAX_TRIES ]; then
			echo "Timed out waiting for database"
			return 1
		fi
		echo "Waiting for DB... ($try/$MAX_TRIES)"
		sleep 2
	done
}

cd /var/www || exit 1

# Install npm deps if needed (useful when volume does not contain node_modules)
if [ -f package.json ]; then
	if [ ! -d node_modules ]; then
		echo "Installing npm packages..."
		# allow failures but continue
		npm install --silent --no-audit --no-fund || true
	fi
fi

# Build assets if Vite manifest is missing (useful with volume-mounted code)
if [ -f package.json ] && [ ! -f public/build/manifest.json ]; then
    echo "Building front-end assets (npm run build)..."
    # try to build; allow failures but continue so container still starts
    npm run build --silent || true
fi

# Ensure composer dependencies present
if [ ! -d vendor ]; then
	echo "Installing composer dependencies..."
	composer install --no-interaction --optimize-autoloader || true
fi

echo "Waiting DB and running migrations..."
if wait_for_db; then
	php artisan migrate --force || true
else
	echo "DB not available, skipping migrations for now"
fi

# Finally, execute the container command (php-fpm by default)
exec "$@"

