## About the project Calculate Data and Chart Rendering

   This is a project to calculate the data as per client requirement and view the data as chart and table according to the inputs from user which are table name and periodicity (weekly and daily).
   
** Step1 ** 
    Download and install laravel project
	Canu use artisan commands to create a new project in our local system 
	In my local system project has created and named as Chart_Assignment


** Step2 ** 
	Here client has shared the tables so i have directly imported the files to my DB 
	Or else we can create tables using the following command
	- php artisan migrate
 
    - Have attached the DB sql file to export the tables in location => database\migrations\assignment.sql

** Step3 **
	- routes\web.php
	Create routes for calculate data and show chart
	
Before start to execute the urls run the following command to initiate the server on local host
- php artisan serve
  
** Step4 ** 

	- [dataCalculation, calculate the data as per in the sample excel sheet](http://localhost/{project name as per in your directory}/public/data_calculation).
	
	- App\Http\Controllers\HomeController => dataCalculation

	# Needed data
		+ Table1 data - data12298
		+ Table2 data - data12335
		+ Table3 data - data12765
	
	- In this function data fetched from the sample tables and processed to calculate the diff column values and convert the timestamp data to date and stored in a new table named as Data_1_Calculation,.. and iterated for all tables and saved in three difffernt tables (as per sample threee tables are there)
		
  
** Step 5 **
	- [Show chart and table, show data in chart and table by using user inputs ](http://localhost/{project name as per in your directory}/public/show_data).

	- App\Http\Controllers\HomeController => showData
	
	- Master tables table has created in DB for havinga the source table names.

	- While loaded the page users need to select both table name and periodicity values from the drop down before submit
	
	- After submit needed parameters to load the chart and table in same page
	
	# Parameters
		+ table (sample table names will be in drop down)
		+ period (Daily, Weekly)
		+ csrf token

** Step6 **
    - After submit the function again called showData

    - Have used chart.js for view the chart data 
	
	- Have fetched data from calculated data table form the above steps (Data_1_Calculation,..) along with the user inputs table name and period
    
	- Data set has prepared to load the chart and table

 	- The page has reloaded with the drop down values and with chart and table 

	- We can change the values of drop down and can submit again with the new given values
	















