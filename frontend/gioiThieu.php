<?php session_start(); ?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giới thiệu XXIV Team</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }
        .header {
            font-size: 2.5em;
            font-weight: 700;
            color: #333;
            margin-bottom: 30px;
            text-align: center;
            padding-top: 20px;
        }
        .profile-card, .story-card, .thank-you-card {
            background: #fff;
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            overflow: hidden;
            margin-bottom: 40px;
        }
        .profile-img {
            max-width: 100%;
            border-radius: 15px 0 0 15px;
        }
        .story-img {
            width: 100%;
            border-radius: 15px;
            object-fit: cover;
            height: 200px;
        }
        .card-title {
            font-size: 1.8em;
            color: #2c3e50;
        }
        .card-subtitle {
            color: #7f8c8d;
            font-size: 1.1em;
        }
        .card-text {
            color: #34495e;
            line-height: 1.8;
            font-size: 1em;
        }
        .story-title, .thank-you-title {
            font-size: 2em;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
<?php require 'components/header.php'?>
    <div class="container mt-5">
        <!-- Phần Giới thiệu Hoàng XXIV -->
        <div class="header">xxiv team</div>
        <div class="profile-card">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="./images/gt1.webp" alt="Hoàng XXIV" class="profile-img img-fluid">
                </div>
                <div class="col-md-8">
                    <div class="card-body p-4">
                        <h2 class="card-title">hoàng xxiv</h2>
                        <h3 class="card-subtitle">ceo/founder</h3>
                        <p class="card-text">Là một người yêu thích mỹ hương, mình đã phát triển một kênh YouTube cá nhân để có thể chia sẻ kiến thức cũng như là kinh nghiệm của mình trong lĩnh vực này.</p>
                        <p class="card-text">Bắt đầu từ năm 2019 đến nay, mình đã may mắn có một lượng lớn người theo dõi trên kênh YouTube cá nhân, đồng thời hiện tại góc hàng mỹ hương hiệu xxiv là hỗn hợp của sai lầm và sai gòn.</p>
                        <p class="card-text">Trong tương lai với năm, mình tin rằng lĩnh vực này còn phát triển nữa, rất mong được các bạn ủng hộ nhé!</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Phần Câu chuyện về XXIV Store -->
        <div class="story-title">câu chuyện về xxiv store</div>
        <div class="story-card">
            <div class="card-body p-4">
                <div class="row g-4">
                    <div class="col-md-6">
                        <p class="card-text">xxiv store là một cửa hàng nước hoa nhỏ nhắn nằm ngay trung tâm Sài Gòn, nơi mà mọi người có thể tìm thấy những mùi hương yêu thích của mình để lan tỏa mùi hương khắp mọi nơi, gợi nhớ đến những ký ức của chính mình và tìm lại được sự tự tin để tỏa sáng mỗi ngày.</p>
                        <p class="card-text">được mở vào giữa năm 2020, xxiv store là nơi mà mình và các bạn trẻ cùng đam mê mỹ hương tập hợp lại để tạo ra một thương hiệu nước hoa mới lạ, rất mong được các bạn ủng hộ nhé!</p>
                    </div>
                    <div class="col-md-6">
                        <img src="./images/gt2.webp" alt="XXIV Store Interior" class="story-img img-fluid">
                    </div>
                </div>
                <div class="row g-4 mt-3">
                    <div class="col-md-6">
                        <img src="./images/gt3.webp" alt="XXIV Store Team" class="story-img img-fluid">
                    </div>
                    <div class="col-md-6">
                        <p class="card-text">Tại XXIV chúng mình luôn đặt chất lượng và lòng tin với khách hàng lên hàng đầu. Cũng vì một phần có gia đình và bạn bè đang ở Pháp, chính tay lựa chọn từ store nên XXIV tự tin 100% hàng chính hãng. Bọn mình sẽ không cam kết bán giá rẻ nhất và cạnh tranh với các bên khác mà chỉ cam kết sẽ bán giá tốt nhất chúng mình có thể. Những sản phẩm chúng mình tư vấn và giới thiệu đều là các sản phẩm đã trực tiếp sử dụng và trải nghiệm để đưa ra lời khuyên thực tế giúp các khách hàng hài lòng.</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Phần Cảm ơn -->
        <div class="thank-you-title">cảm ơn các bạn rất nhiều vì đã tin tưởng và lựa chọn xxiv.</div>
        <div class="thank-you-card">
            <div class="card-body p-4">
                <p class="card-text text-center">các bạn có thể đến với xxiv, tâm sự với chúng mình, cùng chia sẻ đam mê của các bạn về các loại nước hoa bạn thích. với các bạn đang dần do dự hay sử dụng lần đầu cùng đừng ngai nhé, mình sẽ cố gắng trả lời các bạn nhiều nhất, review sản phẩm tốt nhất để các bạn chọn được hương thơm phù hợp với mình nhé!</p>
                <p class="card-text text-center">xxiv love you!</p>
            </div>
        </div>
    </div>
    <?php require 'components/footer.php'?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
</body>
</html>