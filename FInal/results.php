<?php
require_once "header.php";
//gives the page a header
echo"<h3> Survey Results</h3>";
//connects to database throws an error and kills the connection if not
$connection = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

if(!$connection)
{
    die("Connection failed" . $mysqli_connect_error);
}

$query = "";
$result="";
//retrieve responses from survey table
$query = "SELECT * FROM survey";
$result = mysqli_query($connection,$query);
//retrieve number of rows
$n = mysqli_num_rows($result);
//Table headings
echo <<<_END
<h3>Survey Results</h3>
<table>
<tr>
<th>Username</th>
<th>Male/Female</th>
<th>Degree/Course</th>
<th>Start Date</th>
<th>Other Courses/Post Grad</th>
<th>Reasons For Choosing Course</th>
</tr>
</table>
_END;
if($n > 0)
{
    //loop through rows
    for ($i = 0; $i < $n; $i++)
    {
        //Move result to variable
        $row = mysqli_fetch_assoc($result);
        //move answers to table
        echo <<<_END
        <tr>
        <td>{$row['username']}</td>
        <td>{$row['ans1']}</td>
        <td>{$row['ans2']}</td>
        <td>{$row['ans3']}</td>
        <td>{$row['ans4']}</td>
        <td>{$row['ans5']}</td>
        <td>{$row['ans6']}</td>
        <td>{$row['ans7']}</td>
        <td>{$row['ans8']}</td>
        </tr>
_END;
        }
    }
    $query ="SELECT ans1 FROM survey WHERE ans1=1 ";;
    $result = mysqli_query($connection,$query);
    $male = mysqli_num_rows($result);

    $query ="SELECT ans2 FROM survey WHERE ans2=1 ";;
    $result = mysqli_query($connection,$query);
    $female = mysqli_num_rows($result);

    $query ="SELECT ans5 FROM survey WHERE ans5=1 ";;
    $result = mysqli_query($connection,$query);
    $masters = mysqli_num_rows($result);

    $query ="SELECT ans6 FROM survey WHERE ans6=1 ";;
    $result = mysqli_query($connection,$query);
    $phd = mysqli_num_rows($result);

    $query ="SELECT ans7 FROM survey WHERE ans7=1 ";;
    $result = mysqli_query($connection,$query);
    $anotherdegree = mysqli_num_rows($result);

    $query ="SELECT ans8 FROM survey WHERE ans1=8 ";;
    $result = mysqli_query($connection,$query);
    $othereducation = mysqli_num_rows($result);
    if ($n >0 ) {
		
		echo <<<_END
		   <script type=\"text/javascript\" src=\"https://www.gstatic.com/charts/loader.js\"></script>
                    <script type=\"text/javascript\">
                
                      //Loads data visualisations
                      google.charts.load('current', {'packages':['corechart', 'controls']});
                      //setting callback to run
                      google.charts.setOnLoadCallback(drawDataChart);
                
                      //Function to create the data charts
                      function drawChart() 
                      {
                        //Creating the TABLE OF DATA
                        var data = new google.visualization.DataTable();
                        //adding two columns to the table 
                        data.addColumn('string', 'Question');
                        data.addColumn('number', 'Response');
                        //adding rows
                        data.addRows([
		
_END;
		
		
        echo "['Number Of Responses:' {$n}],['Number of Males:', {$male}'],['Number of Females:', {$female}],
 ['Interested in Masters:',{$masters}], ['Interested in PhD:' {$phd}], ['Interested in Another Degree:' {$anotherdegree}]['Intesrested in another form of education:'{$othereducation}]";
        echo <<<_END
  
                        ]);
                                       
                        //Setting the chart options
                        var options = {'title':'Survey Responses',
                                       'width':700,
                                       'height':400,
                                       legend: {position: "left"},
                                       };
                                       
                        //Initialising and drawing the graph in the div called graph
                        var chart = new google.visualization.BarChart(document.getElementById('graph_div'));
                        chart.draw(data, options);
                        
                        //Creates a dashboard which the range slider and the barchart are drawn on, along with grabbing a div to place it in
                        var dashboard = new google.visualization.Dashboard(
                        document.getElementById('dashboard_div'));
                    
                        //Creating the rangeslider and passing some values to it
                               var slider = new google.visualization.ControlWrapper({
                              'controlType': 'NumberRangeFilter',
                              'containerId': 'filter_div',
                              'options': {
                              'filterColumnLabel': 'Response'
                              }
                            });
                        
                        //set pie chart options
                        var pieChart = new google.visualization.ChartWrapper({
                               'chartType': 'PieChart',
                               'containerId': 'pie_div',
                               'options': {
                                   'title':'Responses',
                                   'width': 700,
                                   'height': 400,
                                   'pieSliceText': 'value',
                                    'legend': 'right'
                                }
                        }); 
                        
                        //Binding the slider and piechart to the dashboard and drawing them
                        dashboard.bind(slider, pieChart);
                        dashboard.draw(data);
                        
                      }
                  </script>
                  </head>
                  <body>
                    <!--Table styling -->
                    <table bgcolor='#ffffff' cellspacing='0' cellpadding='2'><tr>
                    <!--graph div-->
                    <td>
                        <div id="graph_div"></div>
                    </td>
                    
                    <!-- creates div to hold other visual displays of data -->
                    <td><div id="dashboard_div">
                        <div id="filter_div"></div>
                        <div id="pie_div"></div>
                    </div></td>
                    </tr></table>                
_END;
    }
else{
    echo "No data to plot";
}

//footer ends the page
require_once "footer.php"
?>