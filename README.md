<h1>User Incidents Management Web Application with Symfony</h1> <p>This is a web application developed with Symfony for managing user incidents. It provides functionalities for users to report incidents and administrators to handle and resolve them.</p> <h2>Features</h2> <ul> <li><strong>User Authentication:</strong> Users can sign up, log in, and log out securely.</li> <li><strong>Incident Reporting:</strong> Users can report incidents by providing details and attaching files.</li> <li><strong>Incident Management:</strong> Administrators can view, assign, prioritize, and resolve incidents.</li> <li><strong>Notifications:</strong> Users and administrators receive notifications for new incidents, status changes, and comments.</li> </ul> <h2>Requirements</h2> <p>Before getting started, ensure you have the following installed on your development environment:</p> <ul> <li>PHP (version 7.2.5 or higher)</li> <li>Symfony (version 5.0 or higher)</li> <li>Composer for dependency management</li> <li>MySQL or another database supported by Symfony</li> </ul> <h2>Setup</h2> <ol> <li>Clone this repository to your local machine:</li> <code>git clone https://repository-url.git</code> <li>Install dependencies using Composer:</li> <code>composer install</code> <li>Create the database schema:</li> <code>php bin/console doctrine:schema:create</code> <li>Start the Symfony server:</li> <code>symfony server:start</code> <li>Navigate to the application URL to access it.</li> </ol> <h2>Usage</h2> <ol> <li>Register for an account if you are a new user, or log in if you already have an account.</li> <li>Create a new incident report, providing all necessary details.</li> <li>Administrators can view and manage incidents from the administration dashboard.</li> <li>Resolve incidents and communicate with users through comments.</li> </ol> <h2>Project Structure</h2> <p>The project structure is as follows:</p> <ul> <li><strong>/config:</strong> Contains configuration files for Symfony.</li> <li><strong>/src:</strong> Contains the main source code of the application, including controllers, entities, and repositories.</li> <li><strong>/templates:</strong> Contains Twig templates for rendering HTML pages.</li> <li><strong>/public:</strong> Contains public assets such as images, stylesheets, and JavaScript files.</li> </ul> <h2>Contributing</h2> <p>Contributions are welcome. If you have suggestions for improvement, issues, or additional features you'd like to add, feel free to open an issue or submit a pull request!</p>