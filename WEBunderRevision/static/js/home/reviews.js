$(document).ready(function () {
  const reviewText = $("#reviewText");
  const reviewAuthor = $("#reviewAuthor");
  let reviews = [];
  let currentIndex = 0;

  function showReview(index) {
    const { text, author } = reviews[index];
    reviewText.css("opacity", 0);
    reviewAuthor.css("opacity", 0);

    setTimeout(() => {
      reviewText.text(`"${text}"`);
      reviewAuthor.text(author);
      reviewText.css("opacity", 1);
      reviewAuthor.css("opacity", 1);
    }, 500);
  }

  function startRotation() {
    showReview(currentIndex);
    setInterval(() => {
      currentIndex = (currentIndex + 1) % reviews.length;
      showReview(currentIndex);
    }, 5000);
  }

  // Fetch reviews from backend
  $.ajax({
    url: "../controller/end-points/controller.php",
    method: "GET",
    data: { requestType: "fetch_reviews" },
    dataType: "json",
    success: function (res) {
      if (res.status === 200 && res.data.length > 0) {
        reviews = res.data;
        startRotation();
      } else {
        reviewText.text("No reviews available at the moment.");
      }
    },
    error: function (xhr, status, error) {
      console.error(error);
      reviewText.text("Failed to load reviews.");
    }
  });
});
