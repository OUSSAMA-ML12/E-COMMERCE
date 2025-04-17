<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Basic Page Needs ================================================== -->
  <meta charset="utf-8">
  <title>Aviato | E-commerce template</title>

  <!-- Mobile Specific Metas ================================================== -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Construction Html5 Template">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
  <meta name="author" content="Themefisher">
  <meta name="generator" content="Themefisher Constra HTML Template v1.0">
  
  <!-- theme meta -->
  <meta name="theme-name" content="aviato" />
  
  <!-- Favicon -->
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('client/images/favicon.png') }}" />
  
  <!-- Themefisher Icon font -->
  <link rel="stylesheet" href="{{ asset('client/plugins/themefisher-font/style.css') }}">
  
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="{{ asset('client/plugins/bootstrap/css/bootstrap.min.css') }}">
  
  <!-- Animate CSS -->
  <link rel="stylesheet" href="{{ asset('client/plugins/animate/animate.css') }}">
  
  <!-- Slick Carousel -->
  <link rel="stylesheet" href="{{ asset('client/plugins/slick/slick.css') }}">
  <link rel="stylesheet" href="{{ asset('client/plugins/slick/slick-theme.css') }}">
  
  <!-- Main Stylesheet -->
  <link rel="stylesheet" href="{{ asset('client/css/style.css') }}">

</head>
<body id="body">

<!-- Start Top Header Bar -->
  @include('layout_second.header')
<!-- End Top Header Bar -->

<section class="page-header">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="content">
          <h1 class="page-name">Checkout</h1>
          <ol class="breadcrumb">
            <li><a href="{{ route('home') }}">Home</a></li>
            <li class="active">Checkout</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
</section>
<div class="container">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Succès!</strong> {{ session('success') }}
            @if(session('order_number'))
                <br>Numéro de commande: <strong>{{ session('order_number') }}</strong>
            @endif
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        
        <script>
            // Vider le panier après commande réussie
            localStorage.removeItem('cart');
            
            // Désactiver le bouton de commande
            document.addEventListener('DOMContentLoaded', function() {
                const submitBtn = document.querySelector('.checkout-form button[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.textContent = 'Commande passée';
                    submitBtn.classList.remove('btn-main');
                    submitBtn.classList.add('btn-success');
                }
            });
        </script>
    @endif
    
    <!-- Le reste de votre contenu -->
</div>
<!-- Main Checkout Content -->
<div class="page-wrapper">
  <div class="checkout shopping">
    <div class="container">
      @if(session('error'))
        <div class="alert alert-danger">
          {{ session('error') }}
        </div>
      @endif
      
      <div class="row">
        <!-- Billing Details -->
        <div class="col-md-8">
          <div class="block billing-details">
            <h4 class="widget-title">Billing Details</h4>
            <form class="checkout-form" method="POST" action="{{ route('productDetails.placeOrder') }}">
              @csrf
              
              <div class="form-group">
                <label for="full_name">Full Name *</label>
                <input type="text" class="form-control" id="full_name" name="full_name" 
                       value="{{ old('full_name') }}" required>
                @error('full_name')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              
              <div class="form-group">
                <label for="user_address">Address *</label>
                <input type="text" class="form-control" id="user_address" name="address" 
                       value="{{ old('address') }}" required>
                @error('address')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              
              <div class="form-group">
                <label for="user_phone">Phone Number *</label>
                <input type="text" class="form-control" id="user_phone" name="phone" 
                       value="{{ old('phone') }}" required>
                @error('phone')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>

              <!-- Hidden fields -->
              <input type="hidden" name="cart" id="cart-data">
              <input type="hidden" name="total_price" id="total-price">

              <button type="submit" class="btn btn-main mt-20">Place Order</button>
            </form>
          </div>
        </div>

        <!-- Order Summary -->
        <div class="col-md-4">
          <div class="product-checkout-details">
            <div class="block">
              <h4 class="widget-title">Order Summary</h4>
              <div id="cart-items">
                <!-- Les éléments du panier seront injectés ici par JavaScript -->
              </div>
              <div class="discount-code">
                <p>Have a discount ? <a data-toggle="collapse" href="#coupon" aria-expanded="false" aria-controls="coupon">Enter it here</a></p>
                <div class="collapse" id="coupon">
                  <div class="well">
                    <form>
                      <input type="text" class="form-control" placeholder="Enter coupon code">
                      <button type="submit" class="btn btn-small btn-solid-border">Apply</button>
                    </form>
                  </div>
                </div>
              </div>
              <ul class="summary-prices">
                <li>
                  <span>Subtotal:</span>
                  <span id="subtotal" class="price">$0.00</span>
                </li>
                <li>
                  <span>Shipping:</span>
                  <span>Free</span>
                </li>
              </ul>
              <div class="summary-total">
                <span>Total</span>
                <span id="total-price-summary">$0.00</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Footer -->
@include('layout_second.footer')

<!-- Scripts -->
<script src="{{ asset('client/plugins/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('client/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('client/plugins/slick/slick.min.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Récupérer le panier depuis localStorage
  const cart = JSON.parse(localStorage.getItem('cart')) || [];
  
  // Rediriger si panier vide
  
  
  // Calculer le total
  const totalPrice = cart.reduce((total, item) => total + (item.price * item.quantity), 0);
  
  // Afficher les articles
  const cartItemsContainer = document.getElementById('cart-items');
  cartItemsContainer.innerHTML = '';
  
  cart.forEach(item => {
    const itemDiv = document.createElement('div');
    itemDiv.className = 'media product-card';
    itemDiv.innerHTML = `
      <div class="media-left">
        <img class="media-object" src="${item.image}" alt="${item.name}" style="width: 80px;">
      </div>
      <div class="media-body">
        <h4 class="media-heading">${item.name}</h4>
        <p>${item.quantity} × $${item.price.toFixed(2)}</p>
        <p>$${(item.price * item.quantity).toFixed(2)}</p>
      </div>
    `;
    cartItemsContainer.appendChild(itemDiv);
  });
  
  // Mettre à jour les totaux
  document.getElementById('subtotal').textContent = `$${totalPrice.toFixed(2)}`;
  document.getElementById('total-price-summary').textContent = `$${totalPrice.toFixed(2)}`;
  
  // Remplir les champs cachés
  document.getElementById('cart-data').value = JSON.stringify(cart);
  document.getElementById('total-price').value = totalPrice.toFixed(2);
  
  // Gérer le coupon (exemple basique)
  const couponForm = document.querySelector('#coupon form');
  if (couponForm) {
    couponForm.addEventListener('submit', function(e) {
      e.preventDefault();
      alert('Coupon functionality would be implemented here');
    });
  }
});
</script>
</body>
</html>