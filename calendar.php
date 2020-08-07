<?
include_once("./global.php");
include_once("./phpParts/auth/allowAdminStudentTeacher.php");

givePoints($con, "view calendar", $session_id, '30');

$query_courses= "SELECT t.id, t.title, q.quiz_category, q.deadline, e.studentId FROM `pssec_quizzes` q INNER join pssec_topics t on q.topic_id=t.id INNER join pssec_courses c on c.id=t.courseId inner join pssec_enrollment e on e.courseId=c.id where e.studentId='$session_id' and q.deadline!='' group by q.topic_id"; 
$result_courses = $con->query($query_courses); 

?>
<!DOCTYPE html>
<html>

<head>
  <?include_once("./phpParts/header.php")?>
  <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="./evo-calendar/css/evo-calendar.min.css">
    <link rel="stylesheet" type="text/css" href="./evo-calendar/css/evo-calendar.orange-coral.min.css">
    <link rel="stylesheet" type="text/css" href="./evo-calendar/css/evo-calendar.midnight-blue.min.css">
    <link rel="stylesheet" type="text/css" href="./evo-calendar/css/evo-calendar.royal-navy.min.css">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fira+Mono&display=swap" rel="stylesheet">
</head>

<body>
   
  <!-- Sidenav -->
  <?include_once("./phpParts/sidenav.php")?>
  <!-- Main content -->
  <div class="main-content" id="panel">
    <!-- Topnav -->
    <?include_once("./phpParts/topnav.php")?>
    <!-- Header -->
    <!-- Header -->
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
              <h6 class="h2 text-white d-inline-block mb-0">Calendar</h6>
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  
                 
                  <li class="breadcrumb-item active" aria-current="page">Calendar</li>
                  
                </ol>
              </nav>
            </div>
            <?if($session_role=="admin" || $session_role=="teacher"){?>
                <div class="col-lg-6 col-5 text-right">
                  <input type="submit" value="Add University" class="btn btn-md btn-neutral" />
                </div>
            <?}?>
            
          </div>
          <!-- Card stats -->
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
      <div class="row">
        <div class="col-xl-12 col-md-21 col-lg-12">
          <div class="card">
            <div class="card-header bg-transparent">
              <div class="row align-items-center">
                <div class="col">
                  <h5 class="h3 mb-0">Calendar</h5>
                </div>
              </div>
            </div>
            <div class="card-body" style="margin:0px;padding:0px;">

                  
                <div class="--noshadow" id="demoEvoCalendar"></div>
                  
                  
                  
            </div>
          </div>
        </div>
      </div>
      <!-- Footer -->
      <?include_once("./phpParts/footer.php")?>
    </div>
  </div>
  <!-- Scripts -->
  <?include_once("./phpParts/footer-scripts.php")?>
  <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="./evo-calendar/js/evo-calendar.min.js"></script>
    <script>
        
        var defaultTheme = getRandom(4);
var today = new Date();
var events = [
    { id: 'cu9q73n', name: "Event #1", date: today.getMonth()+1 +'/3/'+today.getFullYear(), type: "event" },
    { id: 'imwyx6S', name: "Event #2", date: today.getMonth()+1 +'/18/'+today.getFullYear(), type: "event" },
    { id: '9jU6g6f', name: "Holiday #1", date: today.getMonth()+1 +'/10/'+today.getFullYear(), type: "holiday" },
    { id: '0g5G6ja', name: "Birthday #1", date: today.getMonth()+1 +'/14/'+today.getFullYear(), type: "birthday" },
    { id: 'y2u7UaF', name: "Holiday #2", date: today.getMonth()+1 +'/23/'+today.getFullYear(), type: "holiday" },
    { id: 'dsu7HUc', name: "Birthday #2", date: new Date(), type: "birthday" }
];
var active_events = [];
var curAdd, curRmv;

function getRandom(max) {
    return Math.floor((Math.random() * max));
}
$(document).ready(function() {

    $('#demoEvoCalendar').evoCalendar({
        todayHighlight: true,
        format: 'MM dd, yyyy',
        calendarEvents: [
            <?
            if ($result_courses->num_rows > 0)
            { 
                //successfull login
                while($row = $result_courses->fetch_assoc()) 
                { 
                    $originalDate = $row['deadline'];
                    $newDate = date("Y/m/d", strtotime($originalDate));
                    $title = $row['quiz_category'].": ".$row['title'];
                ?>
                    { id: '<?echo $row['id']?>', name: '<?echo $title?>', date: '<?echo $newDate?>', type: "event" },
                <?}
            
            }
            ?>
        ]
    });

    $('[data-set-theme]').click(function (e) {
        setTheme(e.target);
    })

    $('#addBtn').click(function(e) {
        curAdd = getRandom(events.length);
        $('#demoEvoCalendar').evoCalendar('addCalendarEvent', events[curAdd]);
        active_events.push(events[curAdd])
        events.splice(curAdd, 1);
        if (events.length === 0) e.target.disabled = true;
        if (active_events.length > 0) $('#removeBtn').prop("disabled", false);
    })
    $('#removeBtn').click(function(e) {
        curRmv = getRandom(active_events.length);
        $('#demoEvoCalendar').evoCalendar('removeCalendarEvent', active_events[curRmv].id);
        events.push(active_events[curRmv]);
        active_events.splice(curRmv, 1);
        if (active_events.length === 0) e.target.disabled = true;
        if (events.length > 0) $('#addBtn').prop("disabled", false);
    })

    // setTheme($('[data-set-theme]')[defaultTheme]);
    function setTheme(el) {
        var themeName = el.dataset.setTheme;
        $('[data-set-theme]').removeClass('active');
        $(el).addClass('active');
        $('#demoEvoCalendar').evoCalendar('setTheme', themeName);
    }
    // window.onbeforeunload = function(event) {
    //     $('#demoEvoCalendar').evoCalendar('destroy');
    // };

    // SETTINGS DEMO CODE
    var settingsDemo = getRandom($('[data-settings]').length);
    var settingsDemoEl = $('[data-settings]')[settingsDemo];
    var methodDemo = getRandom($('[data-method]').length);
    var methodDemoEl = $('[data-method]')[methodDemo];
    var eventDemo = getRandom($('[data-event]').length);
    var eventDemoEl = $('[data-event]')[eventDemo];

    showSettingsSample($(settingsDemoEl).data().settings);
    showMethodSample($(methodDemoEl).data().method);
    showEventSample($(eventDemoEl).data().event);

    $('[data-settings]').on('click', function (e) {
        var el = $(e.target).closest('[data-settings]');
        var ev = el.data().settings;
        showSettingsSample(ev);
    });
    $('[data-method]').on('click', function (e) {
        var el = $(e.target).closest('[data-method]');
        var ev = el.data().method;
        showMethodSample(ev);
    });
    $('[data-event]').on('click', function (e) {
        var el = $(e.target).closest('[data-event]');
        var ev = el.data().event;
        showEventSample(ev);
    });
});


// hash navigator
$('[data-go*="#"]').on('click', function(e) {
    e.preventDefault();
    var go = $(this).data().go;
    
    if (go === '#top') {
        $('html, body').animate({
            scrollTop: 0,
        },500);
        return;
    } else {
        var top = $(go)[0].offsetTop - $('header')[0].offsetHeight - 10;
    }
    $('html, body').animate({
        scrollTop: top,
    },500);
})


    </script>
  
</body>

</html>
