let params = new URLSearchParams(location.search);
let status = params.get('status');
if(status!==null)
    alert(status);
