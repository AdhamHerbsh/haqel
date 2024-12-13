(function ($) {
  "use strict";

  // Spinner
  var spinner = function () {
    setTimeout(function () {
      if ($("#spinner").length > 0) {
        $("#spinner").removeClass("show");
      }
    }, 1);
  };
  spinner(0);

  // Fixed Navbar
  $(window).scroll(function () {
    if ($(window).width() < 992) {
      if ($(this).scrollTop() > 5) {
        $(".fixed-top").addClass("shadow");
      } else {
        $(".fixed-top").removeClass("shadow");
      }
    } else {
      if ($(this).scrollTop() > 5) {
        $(".fixed-top").addClass("shadow").css("top", -5);
      } else {
        $(".fixed-top").removeClass("shadow").css("top", 0);
      }
    }
  });

  // Back to top button
  $(window).scroll(function () {
    if ($(this).scrollTop() > 300) {
      $(".back-to-top").fadeIn("slow");
    } else {
      $(".back-to-top").fadeOut("slow");
    }
  });
  $(".back-to-top").click(function () {
    $("html, body").animate({ scrollTop: 0 }, 1500, "easeInOutExpo");
    return false;
  });

  // Testimonial carousel
  $(".testimonial-carousel").owlCarousel({
    autoplay: true,
    smartSpeed: 2000,
    center: false,
    dots: true,
    loop: true,
    margin: 25,
    nav: true,
    navText: [
      '<i class="bi bi-arrow-left"></i>',
      '<i class="bi bi-arrow-right"></i>',
    ],
    responsiveClass: true,
    responsive: {
      0: {
        items: 1,
      },
      576: {
        items: 1,
      },
      768: {
        items: 1,
      },
      992: {
        items: 2,
      },
      1200: {
        items: 2,
      },
    },
  });

  // vegetable carousel
  $(".vegetable-carousel").owlCarousel({
    autoplay: true,
    smartSpeed: 1500,
    center: false,
    dots: true,
    loop: true,
    margin: 25,
    nav: true,
    navText: [
      '<i class="bi bi-arrow-left"></i>',
      '<i class="bi bi-arrow-right"></i>',
    ],
    responsiveClass: true,
    responsive: {
      0: {
        items: 1,
      },
      576: {
        items: 1,
      },
      768: {
        items: 2,
      },
      992: {
        items: 3,
      },
      1200: {
        items: 4,
      },
    },
  });

  // Search Table
  $("#search").on("keyup change", function () {
    var value = $(this).val().toLowerCase(); // Get the input value in lowercase
    $("#usersTable tbody tr, #ordersTable tbody tr").filter(function () {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
    });
  });

  // Four objects of interest: drop zones, input elements, gallery elements, and the files.
  // dataRefs = {files: [image files], input: element ref, gallery: element ref}

  const preventDefaults = (event) => {
    event.preventDefault();
    event.stopPropagation();
  };

  const highlight = (event) => event.target.classList.add("highlight");
  const unhighlight = (event) => event.target.classList.remove("highlight");

  const getInputAndGalleryRefs = (element) => {
    const zone = element.closest(".upload_dropZone") || false;
    const gallery = zone.querySelector(".upload_gallery") || false;
    const input = zone.querySelector('input[type="file"]') || false;
    return { input: input, gallery: gallery };
  };

  const handleDrop = (event) => {
    const dataRefs = getInputAndGalleryRefs(event.target);
    dataRefs.files = event.dataTransfer.files;
    handleFiles(dataRefs);
  };

  const eventHandlers = (zone) => {
    const dataRefs = getInputAndGalleryRefs(zone);
    if (!dataRefs.input) return;

    ["dragenter", "dragover", "dragleave", "drop"].forEach((event) => {
      zone.addEventListener(event, preventDefaults, false);
      document.body.addEventListener(event, preventDefaults, false);
    });

    ["dragenter", "dragover"].forEach((event) =>
      zone.addEventListener(event, highlight, false)
    );
    ["dragleave", "drop"].forEach((event) =>
      zone.addEventListener(event, unhighlight, false)
    );

    zone.addEventListener("drop", handleDrop, false);
    dataRefs.input.addEventListener(
      "change",
      (event) => {
        dataRefs.files = event.target.files;
        handleFiles(dataRefs);
      },
      false
    );
  };

  const dropZones = document.querySelectorAll(".upload_dropZone");
  for (const zone of dropZones) {
    eventHandlers(zone);
  }

  const isImageFile = (file) =>
    ["image/jpeg", "image/png", "image/svg+xml"].includes(file.type);
  const isPdfFile = (file) => file.type === "application/pdf";

  function previewFiles(dataRefs) {
    if (!dataRefs.gallery) return;

    let label = document.getElementById("upload_label");

    for (const file of dataRefs.files) {
      let reader = new FileReader();
      reader.readAsDataURL(file);
      reader.onloadend = function () {
        if (isImageFile(file)) {
          let img = document.createElement("img");
          img.className = "upload_img mt-2";
          img.setAttribute("alt", file.name);
          img.src = reader.result;
          dataRefs.gallery.appendChild(img);
          label.innerHTML = file.name;
        } else if (isPdfFile(file)) {
          let embed = document.createElement("embed");
          embed.className = "upload_pdf mt-2";
          embed.setAttribute("type", "application/pdf");
          embed.src = reader.result;
          dataRefs.gallery.appendChild(embed);
          let label = document.getElementById("upload_label");
          label.innerHTML = file.name;
        }
      };
    }
  }

  const handleFiles = (dataRefs) => {
    let files = [...dataRefs.files];

    files = files.filter((item) => {
      if (!isImageFile(item) && !isPdfFile(item)) {
        console.log("Not a valid file type: ", item.type);
      }
      return isImageFile(item) || isPdfFile(item) ? item : null;
    });

    if (!files.length) return;
    dataRefs.files = files;

    previewFiles(dataRefs);
  };

  // Keywords Highlight
  $("#pkeywords").on("change", function () {
    // Get the input value
    const inputVal = $(this).val();

    // Separate keywords by spaces or commas
    const keywords = inputVal.split(/[\s,]+/).filter(Boolean); // Remove empty values

    // Clear the display area
    const $highlightedKeywords = $("#highlighted-keywords");
    $highlightedKeywords.empty();

    // Create and append each highlighted keyword
    keywords.forEach((keyword) => {
      const span = $("<span></span>")
        .text(keyword)
        .addClass("keyword-highlight mx-1 p-2")
        .css({
          backgroundColor: "#ffd700", // Gold color
          color: "#000",
          borderRadius: "5px",
          fontWeight: "bold",
          display: "inline-block",
        });
      $highlightedKeywords.append(span);
    });
  });

  $(".qty-btn").on("click", function () {
    // Get the closest parent element containing the inputs (specific to this row)
    const parentRow = $(this).closest(".quantity");

    // // Retrieve the product ID and current quantity
    const productid = parentRow.find("input[name='pid']").val(); // Find the PID input in this row
    let quantity = parseInt(parentRow.find("input[name='quantity']").val()); // Get the current quantity as an integer

    // // Check if it's a plus or minus button
    if ($(this).hasClass("btn-plus")) {
      quantity += 1; // Increment quantity
    } else if ($(this).hasClass("btn-minus") && quantity > 1) {
      quantity -= 1; // Decrement quantity, but ensure it stays above 1
    }

    // // Update the quantity input value in the UI
    parentRow.find("input[name='quantity']").val(quantity);

    $(".add-to-cart").attr(
      "href",
      "assets/php/cart.php?action=added&pid=" +
        productid +
        "&qty=" +
        quantity +
        ""
    );
  });

  // jQuery function to handle the "Update Cart" button
  $(".update-cart").on("click", function (e) {
    e.preventDefault(); // Prevent the default link behavior

    // Collect product data from the table
    const cartData = [];
    $("table tbody tr").each(function () {
      const row = $(this);
      const pid = row.find("input[name='pid']").val();
      const pname = row.find("input[name='pname']").val();
      const price = row.find("input[name='pprice']").val();
      const pimage = row.find("input[name='pimage']").val();
      const quantity = row.find("input[name='quantity']").val();

      if (pid && quantity) {
        cartData.push({
          PID: pid,
          PNAME: pname,
          PPRICE: price,
          PIMAGE: pimage,
          QUANTITY: parseInt(quantity, 10),
        });
      }
    });

    // Send the cart data to the PHP file via AJAX
    $.ajax({
      url: "assets/php/cart.php", // PHP file to handle the request
      type: "POST",
      data: {
        action: "updateCart",
        cart: cartData,
      },
      success: function (response) {
        // Handle the success response
        sessionStorage["response"] = response;
        location.reload(); // Optionally reload the page to reflect updates
      },
      error: function (xhr, status, error) {
        // Handle errors
        console.error("An error occurred:", error);
        alert("Failed to update cart. Please try again.");
      },
    });
  });
  // When any checkbox (other than "One Time") is clicked
  $(".days-select input.form-check-input:not(#one-time)").on("change", function () {
    if ($(this).is(":checked")) {
      $("#one-time").attr("checked", false); // Uncheck "One Time"
    }
  });

  // When the "One Time" checkbox is clicked
  $("#one-time").on("change", function () {
    if ($(this).is(":checked")) {
      // Uncheck all other checkboxes
      $(".days-select input.form-check-input:not(#one-time)").attr("checked", false);
    }
  });

  // Stars of Wholesaler Rate 
  $('.star-rating').each(function () {
    // Get the number of stars from the data-stars attribute
    const numberOfStars = $(this).data('stars');
    
    // Clear the content in case of re-execution
    $(this).empty();

    // Loop to add stars
    for (let i = 0; i < numberOfStars; i++) {
        $(this).append('<i class="bx bxs-star text-yellow"></i>'); // You can replace this with any star icon
    }
});


})(jQuery);
