<?php
date_default_timezone_set('Asia/Katmandu');
require_once('includes/nepali_calendar.php');
require_once('includes/functions.php');
$cal = new Nepali_Calendar();

////

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{

    if (isset($_POST['nep_submit']))
    {
        $nepdate = $cal->nep_to_eng($_POST['nepyear'], $_POST['nepmon'], $_POST['nepday']);
        if (!crossCheck($_POST['nepyear'], $_POST['nepmon'], $_POST['nepday']))
        {
            $msg = '<p style="color:#FF0000; font-weight:bold">Invalid date input</p>';
        }
        $year = $nepdate['year'];
        $month = $nepdate['month'];
        $month_name = $nepdate['emonth'];
        $day = $nepdate['date'];
        $day_name = $nepdate['day'];
        //
        $year_n = $_POST['nepyear'];
        $month_n = $_POST['nepmon'];
        $day_n = $_POST['nepday'];
        $day_name_n = $nepdate['day'];
        $month_name_n = getMonthName($month_n);
    }
    if (isset($_POST['eng_submit']))
    {

        $nepdate = $cal->eng_to_nep($_POST['engyear'], $_POST['engmon'], $_POST['engday']);

        $year_n = $nepdate['year'];
        $month_n = $nepdate['month'];
        $month_name_n = $nepdate['nmonth'];
        $day_n = $nepdate['date'];
        $day_name_n = $nepdate['day'];
        //
        $year = $_POST['engyear'];
        $month = $_POST['engmon'];
        $day = $_POST['engday'];
        $month_name = date('F', strtotime("$year-$month-$day"));
        $day_name = date('l', strtotime("$year-$month-$day"));
    }
}
else
{
    //if not submitted
    list($year, $month, $day) = explode('-', date('Y-m-d'));
    $month_name = date('F');
    $day_name = date('l');
    //
    $nepdate = $cal->eng_to_nep($year, $month, $day);
    $year_n = $nepdate['year'];
    $month_n = $nepdate['month'];
    $month_name_n = $nepdate['nmonth'];
    $day_n = $nepdate['date'];
    $day_name_n = $nepdate['day'];
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="favicon.png">

        <title>Nepali to English and English to Nepali Date Converter - Nilambar Sharma</title>

        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="css/style.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="assets/js/html5shiv.js"></script>
          <script src="assets/js/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href=".">Nepali - English Date Converter</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href=".">Home</a></li>
                        <li><a href="http://www.nilambar.net/" target="_blank">Blog</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="https://github.com/ernilambar/nepali-english-date-converter" target="_blank"><span class="glyphicon glyphicon-save"></span> Fork at Github</a></li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </div>

        <div class="container">
            <div class="starter-template">
                <h2>Nepali - English Date Converter</h2>  
                <?php if ($_SERVER['REQUEST_METHOD'] == 'POST')
                {
                    ?> 
                    <div class="row">
                        <div class="col-md-3 col-md-offset-2">
                            <p class="alert alert-info">Nepali (BS) : <br/>
    <?php echo $day_n . ' ' . ucfirst($month_name_n) . ' ' . $year_n . ', ' . $day_name_n; ?>
                            </p>
                        </div>
                        <div class="col-md-3 col-md-offset-2">
                            <p class="alert alert-info">English (AD) : <br/>
    <?php echo $day . ' ' . $month_name . ' ' . $year . ', ' . $day_name; ?>
                            </p>
                        </div>
                    </div>
                    <?php
                } //end if
                ?>

                <div class="row">
                    <div class="col-md-12" style="border:none;">
                        <p class="lead text-info">Nepali</p>
                        <form class="form-inline" role="form" action="" method="POST">
                            <div class="form-group">
                                <label class="" for="">Year</label>
<?php getYearList('NP', 'nepyear', $year_n) ?>
                            </div>
                            <div class="form-group">
                                <label class="" for="">Month</label>
<?php getMonthList('nepmon', $month_n, 'NP') ?>
                            </div>
                            <div class="form-group">
                                <label class="" for="">Day</label>
<?php getDayList(32, 'nepday', $day_n); ?>
                            </div>
                            <input type="submit" name="nep_submit" id="nep_submit" value="Convert to English"  class="btn btn-primary"/>
                        </form>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-md-12" style="border:none;">
                        <p class="lead text-info">English</p>
                        <form class="form-inline" role="form" action="" method="POST" >
                            <div class="form-group">
                                <label class="" for="">Year</label>
<?php getYearList('EN', 'engyear', $year) ?>
                            </div>
                            <div class="form-group">
                                <label class="" for="">Month</label>
<?php getMonthList('engmon', $month, 'EN') ?>
                            </div>
                            <div class="form-group">
                                <label class="" for="">Day</label>
<?php getDayList(31, 'engday', $day) ?>
                            </div>                            
                            <input type="submit" name="eng_submit" id="eng_submit" value="Convert to Nepali" class="btn btn-primary"/>
                        </form>
                    </div>
                </div>
            </div>
           
        </div><!-- /.container -->
        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>
