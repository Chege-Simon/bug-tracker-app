import subprocess



command = "php artisan serve"

run_server = subprocess.Popen(command.split(), stdout=subprocess.PIPE)

output, error = run_server.communicate()
