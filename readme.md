This is a test application to solve temper assignment 

This simple project empowered by laravel 6 and Highcharts

NOTE:
-  The admin can use info@temper.works (you can specify allowed emails in Temper config) email to access the charts, this part can be replaced using database.
    <br> To achieve this the project has a Temper Middleware 
  
  - There are three way to add data, \app\Chart.php uncomment only one line from 15 through 17 <br>
  To use db first run the migration
  - After that you have to register and login, if you have privilege then you can see the Analytic button. <br>
  click on it and you see the chart
  - Look at the Y Axis the percentages which dropped harshly are the steps you should consider looking at.
  - In the first two weeks most visitors stuck at step 3 and 4, then in the sequential weeks majority of the <br>
  candidates passed the step 4

- finally to initiate the project just run "npm install" and "composer update" in the root of the project. 


DUSK:
Dusk requires the chromedriver binaries to be executable.
 
 If you're having problems running Dusk, you should ensure the binaries are executable using the following command: chmod -R 0755 vendor/laravel/dusk/bin/
