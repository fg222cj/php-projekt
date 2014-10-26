function getMunicipalityOptions(countyid) {
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("municipality").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","index.php?options=municipality&optionid="+countyid,true);
  xmlhttp.send();
}

function getJobGroupOptions(jobcategoryid) {
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("jobgroup").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","index.php?options=jobgroup&optionid="+jobcategoryid,true);
  xmlhttp.send();
}

function getJobTitleOptions(jobgroup) {
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("jobtitle").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","index.php?options=jobtitle&optionid="+jobgroup,true);
  xmlhttp.send();
}