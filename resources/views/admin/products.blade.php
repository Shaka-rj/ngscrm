@extends('admin.layouts.product')

@section('title', 'Mahsulotlar')

@section('content')
    <div class="list">
        @include('admin.layouts.add_button')    
        <table class="products">
            <tr>
                <th>Mahsulot</th>
                <th>Baza narx</th>
                <th class="x2">%</th>
                <th>Narx</th>
                <th class="x2">QQS</th>
                <th>Oxirgi narx</th>
                <th>Muddati</th>
                <th>Amal</th>
            </tr>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ number_format($product->main_price, 2, '.', ' ') }}</td>
                    <td>{{ $product->main_percent }}</td>
                    <td>{{ number_format($product->price, 2, '.', ' ') }}</td>
                    <td>{{ $product->vat_percent }}</td>
                    <td>{{ number_format($product->price_after_vat, 2, '.', ' ') }}</td>
                    <td>{{ $product->expired_data }}</td>
                    <td>
                        <button class="edit" data-id="{{ $product->id }}"><img src="{{ asset('img/icon/edit.svg') }}"></button>
                        <button class="del" data-id="{{ $product->id }}"><img src="{{ asset('img/icon/delete.svg') }}"></button>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
    <script>
        // **** delete tugmasi uchun ****//
                
        let lastConfirmedButton = null;

        document.querySelectorAll(".del").forEach(button => {
            button.addEventListener("click", function () {
                if (lastConfirmedButton && lastConfirmedButton !== this) {
                    lastConfirmedButton.classList.remove("confirm");
                    lastConfirmedButton.querySelector("img").src = "{{ asset('img/icon/delete.svg') }}";
                }

                if (this.classList.contains("confirm")) {
                    let productId = this.dataset.id;
                    window.location.href = `products/${productId}/delete`;
                } else {
                    this.classList.add("confirm");
                    this.querySelector("img").src = "{{ asset('img/icon/check.svg') }}";
                    lastConfirmedButton = this; 
                }
            });
        });

        //**** ****//

        //**** edit tugmasi uchun ****//

        document.querySelectorAll(".edit").forEach(button => {
            button.addEventListener("click", function () {
                let productId = this.dataset.id;
                window.location.href = `products/${productId}/edit`;
            });
        });

        //**** ****//

    </script>
@endsection