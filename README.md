<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<h1>Api Mobalytics</h1>

<p>This repository contains the source code for Api Mobalytics. Follow the steps below to set up and run the project in your local environment.</p>

<h2>Requirements</h2>
<ul>
    <li>Docker and Docker Compose</li>
    <li>PHP</li>
    <li>Composer</li>
</ul>

<h2>Installation</h2>
<p>Follow these steps to set up the environment and run the application:</p>

<h3>1. Build the containers</h3>
<p>Run the following command to build and start the Docker containers:</p>
<pre><code>docker-compose up -d</code></pre>
<p>This command will bring up all the services defined in the <code>docker-compose.yml</code> file in the background.</p>

<h3>2. Set up the <code>.env</code> file</h3>
<p>Copy the <code>.env.example</code> file and rename it to <code>.env</code>. This file contains all the environment variables required to configure the project:</p>
<pre><code>cp .env.example .env</code></pre>

<h3>3. Install dependencies</h3>
<p>Run the following command to install the project's dependencies:</p>
<pre><code>composer install</code></pre>

<h3>4. Update dependencies</h3>
<p>If you want to update the dependencies to their latest compatible versions, you can run:</p>
<pre><code>composer update</code></pre>

<h3>5. Build the database</h3>
<p>Finally, run the migrations and seeders to build and populate the database:</p>
<pre><code>php artisan migrate:fresh --seed</code></pre>
<p>This command will recreate the database from scratch and run the seeders to fill the tables with initial data.</p>

<h2>Contribution</h2>
<p>If you want to contribute to this project, please follow these steps:</p>
<ol>
    <li>Fork the repository.</li>
    <li>Create a new branch (<code>git checkout -b feature/new-feature</code>).</li>
    <li>Make your changes and commit them (<code>git commit -am 'Add new feature'</code>).</li>
    <li>Push the changes to your repository (<code>git push origin feature/new-feature</code>).</li>
    <li>Open a Pull Request.</li>
</ol>

<h2>License</h2>
<p>This project is licensed under the Api Mobalytics. See the <code>LICENSE</code> file for more details.</p>

</body>
</html>
