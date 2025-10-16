;(($) => {
  // Declare the autoDealership variable
  const autoDealership = window.autoDealership || {}

  // AJAX Car Filtering
  let currentPage = 1

  $("#car-filter-form").on("submit", (e) => {
    e.preventDefault()
    currentPage = 1
    filterCars()
  })

  $("#car-filter-form select, #car-filter-form input").on("change", () => {
    currentPage = 1
    filterCars()
  })

  $("#reset-filters").on("click", () => {
    $("#car-filter-form")[0].reset()
    currentPage = 1
    filterCars()
  })

  function filterCars() {
    const formData = $("#car-filter-form").serialize()

    $("#loading-indicator").show()
    $("#car-results").css("opacity", "0.5")

    $.ajax({
      url: autoDealership.ajaxurl,
      type: "POST",
      data: {
        action: "filter_cars",
        nonce: autoDealership.nonce,
        page: currentPage,
        ...Object.fromEntries(new URLSearchParams(formData)),
      },
      success: (response) => {
        if (response.success) {
          $("#car-results").html(response.data.html).css("opacity", "1")
          $("#results-count").text(response.data.found + " vehicles found")
        }
        $("#loading-indicator").hide()
      },
      error: () => {
        $("#loading-indicator").hide()
        $("#car-results").css("opacity", "1")
        alert("Error loading vehicles. Please try again.")
      },
    })
  }

  // Car Comparison
  let comparisonList = []

  $(document).on("click", ".compare-btn", function () {
    const carId = $(this).data("car-id")
    const index = comparisonList.indexOf(carId)

    if (index > -1) {
      comparisonList.splice(index, 1)
      $(this).removeClass("active")
    } else {
      if (comparisonList.length >= 3) {
        alert("You can compare up to 3 vehicles at a time.")
        return
      }
      comparisonList.push(carId)
      $(this).addClass("active")
    }

    updateComparisonBar()
  })

  function updateComparisonBar() {
    if (comparisonList.length > 0) {
      $("#comparison-bar").show()
      $("#comparison-count").text(comparisonList.length + " car" + (comparisonList.length > 1 ? "s" : "") + " selected")
    } else {
      $("#comparison-bar").hide()
    }
  }

  $("#compare-cars-btn").on("click", () => {
    if (comparisonList.length < 2) {
      alert("Please select at least 2 vehicles to compare.")
      return
    }

    $.ajax({
      url: autoDealership.ajaxurl,
      type: "POST",
      data: {
        action: "get_car_comparison",
        nonce: autoDealership.nonce,
        car_ids: comparisonList,
      },
      success: (response) => {
        if (response.success) {
          displayComparison(response.data)
        }
      },
    })
  })

  function displayComparison(cars) {
    let html = '<table class="comparison-table"><thead><tr><th>Feature</th>'

    cars.forEach((car) => {
      html +=
        '<th><img src="' +
        car.image +
        '" alt="' +
        car.title +
        '" style="width: 100px; height: auto;"><br>' +
        car.title +
        "</th>"
    })

    html += "</tr></thead><tbody>"

    const fields = [
      { label: "Price", key: "price", format: (val) => "$" + Number.parseInt(val).toLocaleString() },
      { label: "Year", key: "year" },
      { label: "Mileage", key: "mileage", format: (val) => Number.parseInt(val).toLocaleString() + " mi" },
      { label: "Transmission", key: "transmission" },
      { label: "Fuel Type", key: "fuel_type" },
      { label: "Engine", key: "engine" },
      { label: "Color", key: "color" },
    ]

    fields.forEach((field) => {
      html += "<tr><td><strong>" + field.label + "</strong></td>"
      cars.forEach((car) => {
        let value = car[field.key] || "N/A"
        if (field.format && value !== "N/A") {
          value = field.format(value)
        }
        html += "<td>" + value + "</td>"
      })
      html += "</tr>"
    })

    html += "<tr><td><strong>Actions</strong></td>"
    cars.forEach((car) => {
      html += '<td><a href="' + car.permalink + '" class="btn btn-small">View Details</a></td>'
    })
    html += "</tr>"

    html += "</tbody></table>"

    $("#comparison-table").html(html)
    $("#comparison-modal").fadeIn()
  }

  $("#clear-comparison").on("click", () => {
    comparisonList = []
    $(".compare-btn").removeClass("active")
    updateComparisonBar()
  })

  // Financing Calculator
  $("#show-calculator").on("click", () => {
    $("#financing-calculator").slideToggle()
  })

  $("#calculate-payment").on("click", () => {
    const price = Number.parseFloat(
      $(".single-car-price")
        .text()
        .replace(/[^0-9.]/g, ""),
    )
    const downPayment = Number.parseFloat($("#down-payment").val()) || 0
    const interestRate = Number.parseFloat($("#interest-rate").val()) / 100 / 12
    const loanTerm = Number.parseInt($("#loan-term").val())

    const principal = price - downPayment

    if (principal <= 0) {
      alert("Down payment cannot be greater than or equal to the vehicle price.")
      return
    }

    const monthlyPayment =
      (principal * (interestRate * Math.pow(1 + interestRate, loanTerm))) / (Math.pow(1 + interestRate, loanTerm) - 1)
    const totalPayment = monthlyPayment * loanTerm + downPayment

    $("#monthly-payment").text("$" + monthlyPayment.toFixed(2))
    $("#total-payment").text("$" + totalPayment.toFixed(2))
    $("#payment-result").slideDown()
  })

  // Gallery Lightbox
  let currentImageIndex = 0
  let galleryImages = []

  $(".gallery-thumb").on("click", function () {
    const index = $(this).data("index")
    $(".gallery-thumb").removeClass("active")
    $(this).addClass("active")

    const mainImage = $(".gallery-main img")
    const newSrc = $(this).attr("src").replace("-150x150", "-800x600")
    mainImage.attr("src", newSrc).data("index", index)
  })

  $(".car-main-image").on("click", function () {
    currentImageIndex = Number.parseInt($(this).data("index")) || 0

    galleryImages = []
    $(".gallery-thumb").each(function () {
      galleryImages.push($(this).attr("src").replace("-150x150", "-800x600"))
    })

    if (galleryImages.length === 0) {
      galleryImages.push($(this).attr("src"))
    }

    showLightbox()
  })

  function showLightbox() {
    $("#lightbox-image").attr("src", galleryImages[currentImageIndex])
    $("#lightbox-modal").fadeIn()
  }

  $(".lightbox-prev").on("click", () => {
    currentImageIndex = (currentImageIndex - 1 + galleryImages.length) % galleryImages.length
    $("#lightbox-image").attr("src", galleryImages[currentImageIndex])
  })

  $(".lightbox-next").on("click", () => {
    currentImageIndex = (currentImageIndex + 1) % galleryImages.length
    $("#lightbox-image").attr("src", galleryImages[currentImageIndex])
  })

  // Modal Close
  $(".modal-close").on("click", function () {
    $(this).closest(".modal").fadeOut()
  })

  $(window).on("click", (e) => {
    if ($(e.target).hasClass("modal")) {
      $(".modal").fadeOut()
    }
  })

  // Keyboard navigation for lightbox
  $(document).on("keydown", (e) => {
    if ($("#lightbox-modal").is(":visible")) {
      if (e.key === "ArrowLeft") {
        $(".lightbox-prev").click()
      } else if (e.key === "ArrowRight") {
        $(".lightbox-next").click()
      } else if (e.key === "Escape") {
        $("#lightbox-modal").fadeOut()
      }
    }
  })
})(window.jQuery)
