
function Status() {
    console.log("eqweqwe");
    // https://api.airtable.com/v0/app1dnIEPdyN4RDwi/logs?api_key=keyHGiTKOgoyrrrm0&sess=nferwfn&pageSize=5&sort%5B0%5D%5Bfield%5D=log_id&sort%5B0%5D%5Bdirection%5D=desc
    $.ajax({
        url: "http://localhost/isd_final/connection/index.php/logs?sess=nferwfn&pageSize=1"
        }).done(function(data) {
            console.log(JSON.parse(data));
            var res = JSON.parse(data);
            var result = JSON.parse(data)['data'][0]['fields'];
            if (res.code == 200) {
                document.getElementById('intro-title').innerHTML = "We're open now.";
                document.getElementById('lbStatus').innerHTML = result.user_name + "is in open-lab, and the " + result.working_machine + "is working" ;
            } else {
                document.getElementById('intro-title').innerHTML = "We're close now.";
                document.getElementById('lbStatus').innerHTML = "" ;
            }
        });
}
