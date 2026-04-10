<style>
    /* Sticky footer styles */
    html, body {
        height: 100%;
        margin: 0;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }
    #content {
        flex: 1 0 auto;
    }
    #footer {
        background-color: #e6b0aa; /* pink color */
        padding: 20px 50;
        text-align: center;
        flex-shrink: 20;
    }
</style>

<div id="footer">
    <h5 class="text-center">@Amour Hijab 2025</h5>
<script type="text/javascript">
    function addToCart(product) {
        const isProductInCart = cart.some(item => item.id_barang === product.id_barang);

        if (!isProductInCart) {
            cart.push(product);
            localStorage.setItem('cart', JSON.stringify(cart));
        } else {
            alert('Produk sudah ada di keranjang!')
        }
    }

    function getCartFromLocalStorage() {
        const storedCart = localStorage.getItem('cart');
        return storedCart ? JSON.parse(storedCart) : [];
    }

    const cart = getCartFromLocalStorage();
</script>
</div>
</create_file>
