//Adrianno Fallone
//Final Project Submission -> main.js


//ensure DOM loads first
document.addEventListener("DOMContentLoaded", function () {

    //Theme switch-functionality for Home Page
    const themeSelection = document.getElementById("themeChange");
    const theme = document.getElementById("themeStyle");

    // If on a page where both elements exist, change stylesheet
    if (themeSelection && theme) {
        themeSelection.addEventListener("change", function () {
            //Updates the href attribute
            theme.setAttribute("href", this.value);
        });
    }



        //Loading products on my site
    const productPrev = document.getElementById("product_preview"); //product card container
    const isProductsPage = window.location.pathname.includes("products");

    //Determine if product container exists and that the PHP data is defined
    if (productPrev && typeof productsFromPHP !== 'undefined') {
        // Erase any existing elements
        productPrev.innerHTML = "";

        //Iterates over each product
        productsFromPHP.forEach(product => {
            //new div created for the product catd
            const card = document.createElement("div");
            card.className = "product-holder";

            //setting the default image and price of the current product
            let image = product.image;
            let price = product.price;

            //Looks for different versions of products
            let hasVersions = Array.isArray(product.versions) && product.versions.length > 0;

            //Default to the first version's image and price if there are more than one version(all of my products have multiple versions)
            if (hasVersions) {
                image = product.versions[0].image || image;
                price = product.versions[0].price || price;
            }

            //Version dropdown HTML if versions exist(applies to all products)
            let versionDropdown = hasVersions ? generateVersionDropdown(product.versions) : '';

            //Sets up the cart control features(ex. quantity controls)
            let cartControls = '';
            if (isProductsPage) {
                cartControls = `
                    <div class="quantity-controls">
                        <button class="qty-btn minus">-</button>
                        <span class="qty">1</span>
                        <button class="qty-btn plus">+</button>
                    </div>
                    <button class="add-to-cart-btn">Add to Cart</button>
                `;
            }

            //Sets the HTML of product cards to include the db data and the above cart controls
            card.innerHTML = `
                <img src="${image}" alt="${product.name}" class="product_image" />
                <h3>${product.name}</h3>
                <p>${product.description}</p>
                <strong class="product-price">${price}</strong>
                ${versionDropdown}
                ${cartControls}
            `;

            //Produc card appended to main continaer
            productPrev.appendChild(card);

            //quantity buttons and add-to-cart button
            if (isProductsPage) {
                setTimeout(() => {
                   
                    const minusBtn = card.querySelector(".minus");
                    const plusBtn = card.querySelector(".plus");
                    const qtySpan = card.querySelector(".qty");
                    let quantity = 1; // Initial quantity is 1

                    //Button to decrease quantity
                    minusBtn?.addEventListener("click", () => {
                        if (quantity > 1) quantity--;
                        qtySpan.textContent = quantity;
                    });

                    //Button to increase quantity
                    plusBtn?.addEventListener("click", () => {
                        quantity++;
                        qtySpan.textContent = quantity;
                    });

                    //Reference to add-to-cart button
                    const addToCartBtn = card.querySelector(".add-to-cart-btn");

                    //event handler for add-to-cart
                    addToCartBtn?.addEventListener("click", () => {
                        const selectedVersionIndex = hasVersions
                            ? card.querySelector(".version-select").value
                            : null;

                        //Copy of product to avoid modification to base image(original)
                        const selectedProduct = { ...product };

                        //Updates product details if there are multiple versionsh and a specific version selected
                        if (hasVersions && selectedVersionIndex !== null) {
                            selectedProduct.selectedVersion = product.versions[selectedVersionIndex];
                            selectedProduct.name = product.versions[selectedVersionIndex].name;
                            selectedProduct.price = product.versions[selectedVersionIndex].price || selectedProduct.price;
                            selectedProduct.image = product.versions[selectedVersionIndex].image || selectedProduct.image;
                        }

                        //Give selected product its quantity value
                        selectedProduct.quantity = quantity;

                      
                        console.log("Add to Cart:", selectedProduct);
                        alert(`${selectedProduct.name} x${quantity} added to cart.`);   //error alert

                        // addToCart function call
                        addToCart(selectedProduct);
                    });

                    //Assignn event listener to version dropdown for dynamic image/price update
                    if (hasVersions) {
                        const select = card.querySelector(".version-select");
                        const img = card.querySelector("img");
                        const priceElem = card.querySelector(".product-price");

                        select?.addEventListener("change", function () {
                            const selected = product.versions[this.value];
                            if (selected.image) img.src = selected.image;
                            if (selected.price) priceElem.textContent = selected.price;
                        });
                    }
                }, 0);
            }
        });
    }

     //Function to generate HTML for the version dropdown object
    
    function generateVersionDropdown(versions) {
        return `<label>Version: <select class="version-select">
            ${versions.map((v, i) => `<option value="${i}">${v.name}</option>`).join("")}
        </select></label>`;
    }

    //Function to assign product to the cart(quantity and version)
    function addToCart(productToAdd) {
        //Get data for POST
        const productId = productToAdd.product_id;
        const versionId = productToAdd.selectedVersion?.version_id || null;
        const quantity = productToAdd.quantity;

        //Create and fill the data to send within POST
        const postData = new URLSearchParams();
        postData.append("product_id", productId);
        postData.append("quantity", quantity);
        if (versionId) postData.append("version_id", versionId);

        //version and quantity info log
        console.log('Adding to cart: versionId=', versionId, 'quantity=', quantity);

        
        if (!versionId) {
            alert('ERROR: No product version selected!'); //alter user if a version is not selected
            return;
        }

        //POST request to 'products.php' with version and quantity attributes
        fetch('products.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `version_id=${encodeURIComponent(versionId)}&quantity=${encodeURIComponent(quantity)}`
        })
            .then(response => {
                //response status log
                console.log('Fetch response status:', response.status, response.statusText);

                // Confirm response
                if (!response.ok) {
                    return response.text().then(text => {
                        throw new Error(`HTTP error ${response.status}: ${text}`);
                    });
                }

                // In the event of a redirect, ensures to navigate browser to new URL
                if (response.redirected) {
                    window.location.href = response.url;
                    return;
                }

                //Returns response text
                return response.text();
            })
            .then(data => {
                //alert user of success in adding to cart
                console.log('Fetch response data:', data);
                alert(`${productToAdd.name} x${quantity} added to cart.`);
            })
            .catch(error => {
                //handle server errors gracefully
                console.error('Fetch error:', error);
                alert('Failed to add item to cart. Please try again.');
            });
    }

});
