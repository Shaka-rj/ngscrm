<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="tourplan.css">
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<body>
    <div class="header">
        <h3>Tumanlar</h3>
    </div>
    <br>
    
    <div class="list">
        <div class="item2">
            <div class="elm2 name">Chilonzor</div>
            <div class="elm">20 000 000</div>
            <hr>
            <div class="elm"><h5>Dorixona</h5><h5>Oylik summa</h5></div>
            <div class="elm"><span>Vigor farm</span><input type="text" class="format"></div> 
            <div class="elm"><span>Vigor farm2</span><input type="text" class="format"></div> 
        </div>
        
        <div class="item2">
            <div class="elm name">Uchtepa</div> 
            <hr>
            <div class="elm">Neo med group</div> 
            <div class="elm">38 op</div>
        </div>
        
        <button class="listbtn">Saqlash</button>
    </div>
    
    <script>
        $(document).ready(function() {
            $('.format').on('input', function() {
                var $this = $(this);
                var value = $this.val().replace(/,/g, '');

                if (!isNaN(value) && value !== '') {
                    var formattedValue = Number(value).toLocaleString('en-US');
                    $this.val(formattedValue);
                }
            });

            $('.format').on('keydown', function(e) {
                if (e.key.length === 1 && !/[0-9]/.test(e.key)) {
                    e.preventDefault();
                }
            });
        });
    </script>
</body>
</html>