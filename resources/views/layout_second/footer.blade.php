<footer class="footer section text-center">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<ul class="social-media">
					<li>
						<a href="https://www.facebook.com/themefisher">
							<i class="tf-ion-social-facebook"></i>
						</a>
					</li>
					<li>
						<a href="https://www.instagram.com/themefisher">
							<i class="tf-ion-social-instagram"></i>
						</a>
					</li>
					<li>
						<a href="https://www.twitter.com/themefisher">
							<i class="tf-ion-social-twitter"></i>
						</a>
					</li>
					<li>
						<a href="https://www.pinterest.com/themefisher/">
							<i class="tf-ion-social-pinterest"></i>
						</a>
					</li>
				</ul>
				<ul class="footer-menu text-uppercase">
					<li>
						<a href="contact.html">CONTACT</a>
					</li>
					<li>
						<a href="shop.html">SHOP</a>
					</li>
					<li>
						<a href="pricing.html">Pricing</a>
					</li>
					<li>
						<a href="contact.html">PRIVACY POLICY</a>
					</li>
				</ul>
				<p class="copyright-text">Copyright &copy;2021, Designed &amp; Developed by <a href="https://themefisher.com/">Themefisher</a></p>
			</div>
		</div>
	</div>
</footer>

<!-- 
    Essential Scripts
    =====================================-->
    
    <!-- Main jQuery -->
    <script src="{{ asset('client/plugins/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap 3.1 -->
    <script src="{{ asset('client/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- Bootstrap Touchpin -->
    <script src="{{ asset('client/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js') }}"></script>
    <!-- Instagram Feed Js -->
    <script src="{{ asset('client/plugins/instafeed/instafeed.min.js') }}"></script>
    <!-- Video Lightbox Plugin -->
    <script src="{{ asset('client/plugins/ekko-lightbox/dist/ekko-lightbox.min.js') }}"></script>
    <!-- Count Down Js -->
    <script src="{{ asset('client/plugins/syo-timer/build/jquery.syotimer.min.js') }}"></script>

    <!-- slick Carousel -->
    <script src="{{ asset('client/plugins/slick/slick.min.js') }}"></script>
    <script src="{{ asset('client/plugins/slick/slick-animation.min.js') }}"></script>

    <!-- Google Mapl -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCC72vZw-6tGqFyRhhg5CkF2fqfILn2Tsw"></script>
    <script type="text/javascript" src="{{ asset('client/plugins/google-map/gmap.js') }}"></script>

    <!-- Main Js File -->
    <script src="{{ asset('client/js/script.js') }}"></script>
    
    <script>
   document.addEventListener('DOMContentLoaded', function () {
    // Fonction pour ajouter un produit au panier
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function () {
            const productId = this.getAttribute('data-id');
            const productName = this.getAttribute('data-name');
            const productPrice = parseFloat(this.getAttribute('data-price'));
            const productImage = this.getAttribute('data-image'); // Image relative path stockée ici

            // Créer l'URL complète de l'image
            const imageUrl = `${window.location.origin}/storage/${productImage}`;

            // Créer un objet produit
            const product = {
                id: productId,
                name: productName,
                price: productPrice,
                image: imageUrl, // Utiliser l'URL complète de l'image
                quantity: 1 // Quantité initiale
            };

            // Récupérer le panier actuel depuis localStorage
            let cart = JSON.parse(localStorage.getItem('cart')) || [];

            // Vérifier si le produit est déjà dans le panier
            const existingProductIndex = cart.findIndex(item => item.id === productId);

            if (existingProductIndex !== -1) {
                // Si le produit existe déjà, on met à jour la quantité
                cart[existingProductIndex].quantity += 1;
            } else {
                // Sinon, on ajoute le produit au panier
                cart.push(product);
            }

            // Sauvegarder le panier mis à jour dans localStorage
            localStorage.setItem('cart', JSON.stringify(cart));

            // Mettre à jour l'icône du panier avec le nombre d'articles
            updateCartCount();
            updateCartDropdown(); // Mettre à jour le dropdown du panier
        });
    });

    // Fonction pour mettre à jour le nombre d'articles dans le panier
    function updateCartCount() {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        const cartCount = cart.reduce((total, item) => total + item.quantity, 0);
        document.getElementById('cart-count').textContent = cartCount; // Mettre à jour l'élément qui affiche le nombre d'articles
    }

    // Fonction pour afficher les produits dans le dropdown du panier
    function updateCartDropdown() {
        const cartDropdown = document.getElementById('cart-dropdown');
        const cartItems = JSON.parse(localStorage.getItem('cart')) || [];

        if (cartItems.length === 0) {
            cartDropdown.innerHTML = '<p>Your cart is empty</p>';
            return;
        }

        cartDropdown.innerHTML = ''; // Vider le contenu actuel du dropdown
        let totalPrice = 0; // Calcul du total

        cartItems.forEach(item => {
            const cartItem = document.createElement('div');
            cartItem.classList.add('media');

            // Utiliser l'URL complète de l'image déjà stockée dans le panier
            const imageUrl = item.image;

            cartItem.innerHTML = `
                <a class="pull-left" href="#!">
                    <img class="media-object" src="${imageUrl}" alt="image" />
                </a>
                <div class="media-body">
                    <h4 class="media-heading"><a href="#!">${item.name}</a></h4>
                    <div class="cart-price">
                        <span>${item.quantity} x</span>
                        <span>$${item.price}</span>
                    </div>
                    <h5><strong>$${(item.price * item.quantity).toFixed(2)}</strong></h5>
                </div>
                <a href="javascript:void(0);" class="remove" data-id="${item.id}">
                    <i class="tf-ion-close"></i>
                </a>
            `;

            cartDropdown.appendChild(cartItem); // Ajouter l'élément du produit dans le dropdown
            totalPrice += item.price * item.quantity;  // Mettre à jour le total du panier
        });

        // Afficher le résumé du panier
        const cartSummary = document.createElement('div');
        cartSummary.classList.add('cart-summary');
        cartSummary.innerHTML = `
            <span>Total</span>
            <span class="total-price">$${totalPrice.toFixed(2)}</span>
        `;
        cartDropdown.appendChild(cartSummary);

        // Ajouter les boutons
        const cartButtons = document.createElement('ul');
        cartButtons.classList.add('text-center', 'cart-buttons');
        cartButtons.innerHTML = `
            <li><a href="{{ route('productDetails.checkout') }}" class="btn btn-small btn-solid-border">Checkout</a></li>
        `;
        cartDropdown.appendChild(cartButtons);

        // Ajouter la fonctionnalité pour supprimer un produit du panier
        const removeButtons = cartDropdown.querySelectorAll('.remove');
        removeButtons.forEach(button => {
            button.addEventListener('click', function () {
                const productId = this.getAttribute('data-id');
                removeItemFromCart(productId);
                updateCartDropdown();  // Mettre à jour le dropdown après suppression
                updateCartCount();  // Mettre à jour le compte d'articles dans le panier
            });
        });
    }

    // Fonction pour supprimer un produit du panier
    function removeItemFromCart(productId) {
        let cartItems = JSON.parse(localStorage.getItem('cart')) || [];
        cartItems = cartItems.filter(item => item.id !== productId);
        localStorage.setItem('cart', JSON.stringify(cartItems));
    }

    // Initialiser l'affichage du panier au chargement de la page
    updateCartDropdown();
    updateCartCount();
});

    </script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Récupérer le panier depuis localStorage
    const cart = JSON.parse(localStorage.getItem('cart')) || [];

    // Sélectionner l'élément où les produits du panier seront affichés
    const cartItemsContainer = document.getElementById('cart-items');
    const subtotalElement = document.getElementById('subtotal');
    const totalPriceElement = document.getElementById('total-price');

    // Initialiser les prix
    let subtotal = 0;
    let totalPrice = 0;

    // Vérifier si le panier est vide
    if (cart.length === 0) {
        cartItemsContainer.innerHTML = "<p>Your cart is empty</p>";
        subtotalElement.textContent = "$0";
        totalPriceElement.textContent = "$0";
        return;
    }

    // Boucler sur chaque produit du panier
    cart.forEach(item => {
        // Créer un élément pour chaque produit
        const productCard = document.createElement('div');
        productCard.classList.add('media');

        productCard.innerHTML = `
            <a class="pull-left" href="product-single.html">
                <img class="media-object" src="${item.image}" alt="Product Image" />
            </a>
            <div class="media-body">
                <h4 class="media-heading"><a href="product-single.html">${item.name}</a></h4>
                <p class="price">${item.quantity} x $${item.price}</p>
                <span class="remove" data-id="${item.id}">Remove</span>
            </div>
        `;
        cartItemsContainer.appendChild(productCard);

        // Calculer le sous-total pour chaque produit
        subtotal += item.price * item.quantity;

        // Calculer le prix total
        totalPrice = subtotal; // Si vous avez des frais d'expédition ou d'autres coûts, vous pouvez les ajouter ici.
    });

    // Mettre à jour les sous-totaux et le prix total
    subtotalElement.textContent = `$${subtotal.toFixed(2)}`;
    totalPriceElement.textContent = `$${totalPrice.toFixed(2)}`;

    // Ajouter un événement pour supprimer un produit du panier
    const removeButtons = cartItemsContainer.querySelectorAll('.remove');
    removeButtons.forEach(button => {
        button.addEventListener('click', function () {
            const productId = this.getAttribute('data-id');
            removeItemFromCart(productId);
            updateCartDisplay();  // Mettre à jour l'affichage après suppression
        });
    });

    // Fonction pour supprimer un produit du panier
    function removeItemFromCart(productId) {
        let cartItems = JSON.parse(localStorage.getItem('cart')) || [];
        cartItems = cartItems.filter(item => item.id !== productId);
        localStorage.setItem('cart', JSON.stringify(cartItems));
    }

    // Fonction pour mettre à jour l'affichage du panier
    function updateCartDisplay() {
        // Recharger et mettre à jour l'affichage
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        cartItemsContainer.innerHTML = ''; // Vider le contenu actuel
        subtotal = 0;
        totalPrice = 0;
        cart.forEach(item => {
            const productCard = document.createElement('div');
            productCard.classList.add('media');

            productCard.innerHTML = `
                <a class="pull-left" href="product-single.html">
                    <img class="media-object" src="${item.image}" alt="Product Image" />
                </a>
                <div class="media-body">
                    <h4 class="media-heading"><a href="product-single.html">${item.name}</a></h4>
                    <p class="price">${item.quantity} x $${item.price}</p>
                    <span class="remove" data-id="${item.id}">Remove</span>
                </div>
            `;
            cartItemsContainer.appendChild(productCard);

            // Calculer le sous-total et le prix total
            subtotal += item.price * item.quantity;
            totalPrice = subtotal;
        });

        // Mettre à jour les sous-totaux et le prix total
        subtotalElement.textContent = `$${subtotal.toFixed(2)}`;
        totalPriceElement.textContent = `$${totalPrice.toFixed(2)}`;
    }
});
</script>





