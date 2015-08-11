project-template-cakephp
========================

This is a template for the new CakePHP project.

Install
-------

When starting a new PHP project, do the following:


```bash
# Initiate the new work space
mkdir new-project
cd new-project
git init
# Kick off the project (this is needed for --squash merge later)
touch README.md
git add README.md
git commit -m "Initial commit"
# Get project-template
git remote add template https://github.com/QoboLtd/project-template-cakephp.git
git remote update
# Merge latest tag (or use 'template/master' instead)
git merge --squash $(git tag | tail -n 1)
git commit -m "Merged project-template-cakephp ($(git tag | tail -n 1))"
# Finalize the setup
composer install
./vendor/bin/phake dotenv:create
```

Test
----

Now that you have the project template installed, check that it works
before you start working on your changes.  Fire up the PHP web server:

```
bin/cake server -H localhost -p 8000
```

In your browser navigate to [http://localhost:8000](http://localhost:8000).  
You should see the standard CakePHP home page.  If you do, all parts 
are in place.

Usage
-----

Now you can develop your PHP project as per usual, but with the following
advantages:

* Per-environment configuration using .env file, which is ignored by git
* Powerful build system (phake-builder) integrated
* Composer integrated with vendor/ folder added to .gitignore .
* PHPUnit integrated with tests/ folder and an example unit test.
* Sensible defaults for best practices - favicon.ico, robots.txt, GPL, etc

For example, you can easily automate the build process of your application
by modifying the included Phakefile.  Run the following command to examine
available targets:

```
./vendor/bin/phake -T
```

As you can see, there are already placeholders for app:install, app:update,
and app:remove.  You can populate these, remove them or add more, of
course.

Here is how to run your unit tests:

```
./vendor/bin/phpunit --coverage-text --colors tests/
```

There's an example one for you, so now you have no excuse NOT to write
them.

