# README #

This README would normally document whatever steps are necessary to get your application up and running.


### Instruction to be followed to setup ###

1. clone this repository from this command "git clone https://github.com/chandanavyatech/laravelvueapp"

2. Composer Update: Now go to terminal and navigate to laravelvueapp and run "composer update", if you PHP version and PHP version in composer.json is different it will throw error, so need to changes PHP version in composer.json

3. permission changes
    - change permission to 777 for "storage" folder 

4. DB migrations
    - run artisan command to migrate DB: "php artisan migrate" 

5. Vue Dependencies
    - npm install
    - npm run watch


* need to run "php artisan config:cache"
