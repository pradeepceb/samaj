@include('Frontend.employee-report-header')

<body>
 
<style>
    body{
        height: 98%;
    }
    .active>a{
            background-color: #1b55e2 !important;
            color: #fff !important;
            width: 21px !important;
            text-align: center !important;
            font-weight: 700 !important;
            border: 0px !important;
            margin-top: -6px !important;
    }
</style> 

<body> 
    <?php 
    if(count($_GET)==0){
       $curl = "";
    } else {
       foreach($_GET as $key => $value){
       $data[] = $key."=".$value."&";
       } 
       if(count($data) > 0){
           $seturl=substr(implode("",$data), 0, -1);
           $curl = "?".$seturl;
       } else {
           $curl="";
       }
    }
    ?> 
@php
    function getmonth($m){
            $dateObj   = DateTime::createFromFormat('!m', $m);
            return $dateObj->format('F'); 
    }

if(count($_GET)==0){
    $from_date= "";
    $to_date= "";
} else { 
    if(!isset($_GET['to_date']) && !isset($_GET['from_date'])){
    $to_date= "";
    $from_date="";
    } else {
    $to_date= $_GET['to_date'];
    $from_date= $_GET['from_date'];
    }
}   
if(isset($_GET['active_type'])){
    $active_type= $_GET['active_type'];
} else {
    $active_type= "all";
}  
@endphp

        <!--  BEGIN CONTENT AREA  -->
        <div  class="main-content">
                <div class="">
                    <div class="row">
                        <div id="tableCaption" class="col-lg-12 col-12 layout-spacing">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-header">
                                    <div class="row">
                                    	<div class="col-xl-12 col-md-12 col-sm-12 col-12 text-center">
                                            @php
                                            date_default_timezone_set('Asia/Kolkata');
                                            $time = date("M d, Y h:i A");
                                                      @endphp
                                            <h5 class="data-heading1 pt-0">The Samaj<span>Report run on: {{ $time }}</span></h5>
                                            <h3 class="data-heading p-0">BIRTHDAY FALL REPORT</h3>
 
                                            <div style="text-align: right; margin-top:-35px; padding-bottom:7px;">
                        <a href="{{ url('/') }}/birthday-fall-report-print<?php echo $curl; ?>" class="btn btn-primary" target="_blank" id="print_btn" ><i class="fa fa-print"></i> Print</a>
                                                
                        <a class="btn btn-primary" target="_blank" id="xl_btn" href="{{ url('/') }}/birthday-fall-report-xl<?php echo $curl; ?>" >Excel</a>
                                                 
                                        </div>

                                        </div>

                                  
                                        <div class="col-xl-12 col-md-12 col-sm-12 col-12" style="padding-right: 0px !important;
                                        padding-left: 0px !important;">
                                                  
        <form method="GET" action="" class="form-inline report-area">
            <label>From Date:</label>
            <input type="date" class="col-lg-2 form-control" value="{{ $from_date }}" name="from_date" required>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <label>To Date:</label>
                
            <input type="date" class="col-lg-2 form-control" value="{{ $to_date }}"  name="to_date" required>

            &nbsp;&nbsp;
            <label>Emp Status:</label>
            <select name="active_type" class="col-lg-2 form-control" required>
                <option value="all" @php if($active_type=="all"){echo "selected";} @endphp>All</option>
                <option value="A" @php if($active_type=="A"){echo "selected";} @endphp>Active</option>
                <option value="I" @php if($active_type=="I"){echo "selected";} @endphp>Inactive</option>
            </select>

            &nbsp;&nbsp;
                    <table >
                    <tr>
                        <td><button type="submit" class="btn btn-primary report-btn" value="">Search</button></td>
                        <td><a href="{{ url('/') }}/birthday-fall-report" class="btn btn-info "><i class="fa fa-refresh" aria-hidden="true"></i></a></td>
                    </tr>
                </table>
                                        </div>
                                    </div>
                                </div>
                                  
                                <div class="widget-content widget-content-area"  style="padding-bottom: 0px; padding-left: 7px;padding-right: 7px;">
        
                <div class="table-responsive" style="margin-top: 5px; height:595px; overflow:scroll;">
    {{-- <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for code.." title="Type Code" class="form-control " style="width: 15%; float: right; margin-bottom: 5px;"> --}}
    <table class="table" id="myTable" width="100%">
        <thead>
            <tr>
                <th class="text-center">Emp. Code</th>
                <th class="text-center">Employee Name</th>
                <th class="text-center">Designation</th>
                <th class="text-center">Department</th>
                <th class="text-center">Active Type</th>
                <th class="text-center">DOB</th>
                <th class="text-center">DOJ</th>
                <th class="text-center">Birth Day</th>
                <th class="text-center">Edit</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employee_list as $val)
            <tr> 
                <td class="text-center">{{ $val->employee_code }}</td>
                <td class="text-primary text-center">{{ $val->emp_name }}</td>
                <td class="text-center">{{ $val->desg_name }}</td>
                <td class="text-center">{{ $val->dept_name }}</td>
                <td class="text-center">
                    @if($val->active_type=="I")
                    <button style="font-size: initial;padding: revert;" class="btn btn-danger btn-sm">Inactive</button>
                    @elseif ($val->active_type=="A")
                    <button style="font-size: initial;padding: revert;" class="btn btn-success btn-sm">Active</button>
                    @endif
                </td>
                <td class="text-center">
                    @if(!$val->DOB=="")
                    {{ date('d/m/Y', strtotime($val->DOB)) }}
                    @endif
                </td>
                <td class="text-center">
                    @if(!$val->DOJ=="")
                            {{ date('d/m/Y', strtotime($val->DOJ)) }}
                    @endif
                </td>
                <td class="text-center"> 
                @if (!$val->DOB== NULL)
                {{ date('d-M', strtotime($val->DOB)) }}  
                @endif
                </td>
                <td class="text-center" >
                    <a onclick="storetype('OFFICIAL_DETAILS','{{ $val->emp_no }}')" href="javascript:void(0)" title="Edit" class="editbtn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                    </a>
                </td>
            </tr>
            @endforeach  
        </tbody>
        <tfoot>
            <tr>
                <td align="right" colspan="9">{{ $employee_list->links('paginate.pager6') }} </td>
            </tr>
        </tfoot>
    </table>
            
                </div>
                            
                                </div>
                                 



                            </div>
                        </div>

                    </div>
                </div>

        </div>

            <script type="text/javascript">
                function PrintTable() {
                    var printWindow = window.open('', '', 'height=800,width=800');
                    printWindow.document.write('<html><head><title>Table Contents</title>');
                    var style = '<style type = "text/css">';
                        style = style + "body{ font-family: Arial;font-size: 10pt; }";
                        style = style + "table{border: 1px solid #ccc;border-collapse: collapse;}";
                        style = style + "table th{ background-color: #F7F7F7; color: #333;font-weight: bold;}";
                        style = style + "table th, table td{padding: 5px; border: 1px solid #ccc;}";
                        style = style + ".st1{color:black; font-weight: 700; font-size: 13px; letter-spacing: 1px; text-transform: uppercase;}";
                        style = style + "</style>";
                    printWindow.document.write(style);
                    printWindow.document.write('</head>');
                    printWindow.document.write('<body>');
                    var divContents = document.getElementById("dvContents").innerHTML;
                    printWindow.document.write(divContents);
                    printWindow.document.write('</body>');
                    printWindow.document.write('</html>');
                    printWindow.document.close();
                    printWindow.print();
                }
            </script> 




        <script> 
            var g_url = `{{ url('/') }}`;
            function storetype(type,num){
              window.localStorage.clear();
              var expires = "";
              var date = new Date();
              let data = {"lastbtn":type,"date": date};
              window.localStorage.setItem("samaj_data", JSON.stringify(data));
              date.setTime(date.getTime() + (1 * 24 * 60 * 60 * 1000));
              expires = "; expires=" + date.toUTCString();
              document.cookie = "samaj_data" + "=" + (type || "") + expires + "; path=/";
              window.open(`${g_url}/employee_edit_master?search_emp=${num}`, '_blank')
             }
function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
            </script>
        @extends('Frontend.employee-report-footer')
      