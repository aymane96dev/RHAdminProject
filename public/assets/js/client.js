    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });

        
        let state=false;

        function changestate()
        {
            if(state){
                document.getElementById('passwordlogin').setAttribute('type','password');
                state=false;
                document.getElementById('eye4pwrd').className = 'fas fa-eye';
            }
            else
            {
                document.getElementById('passwordlogin').setAttribute('type','text');
                state=true;
                document.getElementById('eye4pwrd').className = 'fas fa-eye-slash';
            }
        }