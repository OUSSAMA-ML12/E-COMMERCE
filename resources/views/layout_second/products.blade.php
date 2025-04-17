<!DOCTYPE html>

<!--
 // WEBSITE: https://themefisher.com
 // TWITTER: https://twitter.com/themefisher
 // FACEBOOK: https://www.facebook.com/themefisher
 // GITHUB: https://github.com/themefisher/
-->

<html lang="en">
<head>

  <!-- Basic Page Needs
  ================================================== -->
  <meta charset="utf-8">
  <title>Aviato | E-commerce template</title>

  <!-- Mobile Specific Metas
  ================================================== -->
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
  <!-- bootstrap.min css -->
  <link rel="stylesheet" href="{{ asset('client/plugins/bootstrap/css/bootstrap.min.cs') }}s">
  
  <!-- Animate css -->
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
					<h1 class="page-name">Porducts</h1>
					<ol class="breadcrumb">
						<li><a href="index.html">Home</a></li>
						<li class="active">Porducts</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
</section>


<section class="products section">
	<div class="container">
		<div class="row">
			
        @foreach($products as $product)
        <div class="col-md-4">
    <div class="product-item">
        <div class="product-thumb">
            <span class="bage">Sale</span>
            <img class="img-responsive" src="{{ asset('storage/'.$product->image) }}" alt="product-img" />
            <div class="preview-meta">
                <ul>
                    <li>
                        <span data-toggle="modal" data-target="#product-modal">
                            <i class="tf-ion-ios-search-strong"></i>
                        </span>
                    </li>
                    <li>
                        <a href="#!" ><i class="tf-ion-ios-heart"></i></a>
                    </li>
                    <li>
                    <button class="add-to-cart" 
        data-id="{{ $product->id }}" 
        data-name="{{ $product->name }}" 
        data-price="{{ $product->price }}" 
        data-image="{{ $product->image }}">Add to Cart</button>        
                </li>
                </ul>
            </div>
        </div>
        <div class="product-content">
            <h4><a href="product-single.html">{{ $product->name }}</a></h4>
            <p class="price">${{ number_format($product->price, 2) }}</p>
        </div>
    </div>
</div>

    @endforeach
			
		
		<!-- Modal -->
		<div class="modal product-modal fade" id="product-modal">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<i class="tf-ion-close"></i>
			</button>
		  	<div class="modal-dialog " role="document">
		    	<div class="modal-content">
			      	<div class="modal-body">
			        	<div class="row">
			        		<div class="col-md-8 col-sm-6 col-xs-12">
			        			<div class="modal-image">
				        			<img class="img-responsive" src="images/shop/products/modal-product.jpg" alt="product-img" />
			        			</div>
			        		</div>
			        		<div class="col-md-4 col-sm-6 col-xs-12">
			        			<div class="product-short-details">
			        				<h2 class="product-title">GM Pendant, Basalt Grey</h2>
			        				<p class="product-price">$200</p>
			        				<p class="product-short-description">
			        					Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem iusto nihil cum. Illo laborum numquam rem aut officia dicta cumque.
			        				</p>
			        				<a href="cart.html" class="btn btn-main">Add To Cart</a>
			        				<a href="product-single.html" class="btn btn-transparent">View Product Details</a>
			        			</div>
			        		</div>
			        	</div>
			        </div>
		    	</div>
		  	</div>
		</div><!-- /.modal -->

		</div>
	</div>
</section>








@include('layout_second.footer')



  </body>
  </html>
