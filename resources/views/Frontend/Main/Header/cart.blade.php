<li class="nav-item">
    <button type="button" class="nav-link box cart-btn">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M15.55 13c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.37-.66-.11-1.48-.87-1.48H5.21l-.94-2H1v2h2l3.6 7.59-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7l1.1-2h7.45zM6.16 6h12.15l-2.76 5H8.53L6.16 6zM7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/></svg>
        <span class="badge">5</span>
    </button>
    <ul class="dropdown-menu cart-list">
        <li class="cart-item">
            <div class="media">
                <div class="media-left">
                    <a href="books-detail.html">
                        <img alt="" class="media-object" src="{{ asset('assets/frontend/images/books/small/pic1.jpg')}}">
                    </a>
                </div>
                <div class="media-body">
                    <h6 class="dz-title"><a href="books-detail.html" class="media-heading">Real Life</a></h6>
                    <span class="dz-price">$28.00</span>
                    <span class="item-close">&times;</span>
                </div>
            </div>
        </li>
        <li class="cart-item">
            <div class="media">
                <div class="media-left">
                    <a href="books-detail.html">
                        <img alt="" class="media-object" src="{{ asset('assets/frontend/images/books/small/pic2.jpg')}}">
                    </a>
                </div>
                <div class="media-body">
                    <h6 class="dz-title"><a href="books-detail.html" class="media-heading">Home</a></h6>
                    <span class="dz-price">$28.00</span>
                    <span class="item-close">&times;</span>
                </div>
            </div>
        </li>
        <li class="cart-item">
            <div class="media">
                <div class="media-left">
                    <a href="books-detail.html">
                        <img alt="" class="media-object" src="{{ asset('assets/frontend/images/books/small/pic3.jpg')}}">
                    </a>
                </div>
                <div class="media-body">
                    <h6 class="dz-title"><a href="books-detail.html" class="media-heading">Such a fun age</a></h6>
                    <span class="dz-price">$28.00</span>
                    <span class="item-close">&times;</span>
                </div>
            </div>
        </li>
        <li class="cart-item text-center">
            <h6 class="text-secondary">Totle = $500</h6>
        </li>
        <li class="text-center d-flex">
            <a href="cart" class="btn btn-sm btn-primary me-2 btnhover w-100">View Cart</a>
            <a href="shop-checkout.html" class="btn btn-sm btn-outline-primary btnhover w-100">Checkout</a>
        </li>
    </ul>
</li>
