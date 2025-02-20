@extends('admin.layouts.product')

@section('title', 'Mahsulot yaratish')

@section('content')
    <div class="list">
        <form method="post" action="{{ route('admin.products.store') }}">
        @csrf
        <table class="products">
            <tr>
                <th>Mahsulot</th>
                <th>Baza narx</th>
                <th class="x2">%</th>
                <th>Narx</th>
                <th class="x2">QQS</th>
                <th>Oxirgi narx</th>
                <th>Amal</th>
            </tr>
            <tr>
                <td><input type="text" name="name" required></td>
                <td><input type="number" step="0.01" id="main_price" name="main_price" value="0" required></td>
                <td class="x2"><input type="number" name="main_percent" id="main_percent" value="0" required></td>
                <td><input type="number" step="0.01" name="price" value="0" required></td>
                <td class="x2"><input type="number" name="vat_percent" id="vat_percent" value="0" required></td>
                <td><input type="number" step="0.01" name="price_after_vat" value="0" required></td>
                <td><input type="submit" value="Yaratish"></td>
            </tr>
            <tr>
                <td><input type="text" value="Maxsus narx" readonly></td>
                <td><input type="number" step="0.01" name="main_price2" value="0"></td>
                <td class="x2"><input type="number" name="main_percent2" value="0"></td>
                <td><input type="number" step="0.01" name="price2" value="0"></td>
                <td class="x2"><input type="number" name="vat_percent2" value="0"></td>
                <td><input type="number" step="0.01" name="price_after_vat2" value="0"></td>
            </tr>
            <tr>
                <td>Tavsiya:</td>
                <td id="main_price2"></td>
                <td class="x2" id="main_percent2"></td>
                <td id="price2"></td>
                <td class="x2" id="vat_percent2"></td>
                <td id="price_after_vat2"></td>
                <td><button type="button" onclick="calculate()" class="calculate-button">Hisoblash</button></td>
            </tr>
        </table>
    </form>
</div>
<script>
    const main_price = document.getElementById('main_price');
    const main_percent = document.getElementById('main_percent');
    const vat_percent = document.getElementById('vat_percent');
    
    const main_price2 = document.getElementById('main_price2');
    const price2 = document.getElementById('price2');
    const price_after_vat2 = document.getElementById('price_after_vat2');
        
    function calculate(){
        let m_price = parseFloat(main_price.value);
        let m_percent = parseInt(main_percent.value);
        
        let price_p = parseFloat((m_price + (m_percent / 100) * m_price).toFixed(2));
        price2.innerHTML = price_p;
            
        let vat = parseInt(vat_percent.value);
            
        price_after_vat2.innerHTML = (price_p + (vat / 100) * price_p).toFixed(2)
    }
</script>
@endsection