<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p>This project is fully setup to be server instant</p>

## Project Owner
<p>Michael Watts</p>
<p>michael.watts25@outlook.com</p>

## About This Project
<p>Using Laravel and the Github API I have built a basic search functionality that allows the end user to search for users and to display their profile information along with there top 5 most rated repositories.</p>
<p>The below explains some crucial parts and questions/answers to this project</p>

## Reasons for my choice of development
<p>1) I didn't use any third party packages or wrappers for GitHub as I felt 1/2 curl requests to the API were all I needed.</p>
<p>2) Reasons for using migrations/DB are that i could utilise a model to get top 5 starred for a certain user.</p>
<p>3) I did not use full authentication with tokens for this project because github allows for up to 60 requests per hour. For bigger teams or a bigger use case it's simple enough to add the token to the .env and use in the curl requests, this would also mean I would have to setup an app/project on the settings of my account on Github</p>

## Getting Started
<p>1) Add your DB credentials to .env</p>
<p>2) Run 'composer install'</p>
<p>3) Run 'php artisan migrate'</p>
<p>4) You can serve this app using laravel valet or MAMP</p>

## Rate Limiting
<p>Conditional Requests - The API supports conditional requests, this is respecting rate limits by caching information that haven't changed.</p>

## Testing 
<p>Testing can be put into place through unit testing, a good example could be for the search results, we'd always want to make sure that the data coming back from the api matched what we needed in the model, or the keys were valid.</p>

## Version Control
<p>Git Flow - This project uses Gitflow and versioning by using the V tag e.g. 1.0.0. it's important to work from a feature branch, and when that branch is finished you simply release a new version. This way teams can keep track of important releases and have a brighter gitlog for larger teams.</p>
