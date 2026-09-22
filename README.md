Step 1: Open Ubuntu (WSL)

Press Start → search for Ubuntu and open it.

You’ll be inside your Ubuntu shell.

🔹 Step 2: Update and Install Redis

Run these commands inside Ubuntu:

sudo apt update
sudo apt install redis-server -y

Step 3: Enable Redis Service

After installation, enable Redis to start automatically:

sudo systemctl enable redis-server

Start Redis now:

sudo systemctl start redis-server

🔹 Step 4: Verify Redis is Running

Check the status:

sudo systemctl status redis-server

You should see active (running).
Press q to exit the status view.

Or test it directly:

redis-cli ping

If it replies with:

PONG

🎉 Redis is running correctly.

🔹 Step 6: Test Laravel with Redis

Run in Laravel Tinker:

php artisan tinker

Then:

Cache::put('foo', 'bar', 10);
Cache::get('foo');


It should return:

"bar"
