<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZooParc Zoological Park</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .header {
            background: url('../../images/parrot.jpg') no-repeat center center;
            background-size: cover;
            color: #fff;
            text-align: center;
            padding: 100px 20px;
        }
        .header h1 {
            font-size: 4rem;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .header p {
            font-size: 1.5rem;
            max-width: 800px;
            margin: 0 auto;
        }
        .container {
            padding: 40px 20px;
        }
        .section-title {
            font-size: 2.5rem;
            margin-bottom: 30px;
            color: #005f00;
            text-align: center;
            font-weight: bold;
        }
        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 350px;
            overflow: hidden;
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: scale(1.05);
        }
        .card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .card-content {
            padding: 15px;
        }
        .card-title {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: #005f00;
        }
        .card-text {
            font-size: 1rem;
            color: #333;
            margin-bottom: 15px;
        }
        .cta {
            background-color: #005f00;
            color: #fff;
            text-align: center;
            padding: 40px 20px;
            margin-top: 60px;
            border-radius: 10px;
        }
        .cta h2 {
            font-size: 2rem;
            margin-bottom: 20px;
        }
        .cta a {
            color: #fff;
            background: #00b359;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 1.2rem;
        }
        .cta a:hover {
            background: #00994d;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div>

    
<!-- <?php include '../../components/userHeader.php'; ?> -->
 
    <header class="header">
        
        <h1>Welcome to ZooParc Zoological Park</h1>
        <p>Home to 2,000 animals of 200 different species, including our famous giant pandas. Explore 70 hectares of diverse habitats and learn more about wildlife conservation.</p>
    </header>

    <div class="container">
        <section>
            <h2 class="section-title">Our Animals</h2>
            <div class="card-container">
                <div class="card">
                    <img src="../../images/lion1.jpg" alt="Lions">
                    <div class="card-content">
                        <div class="card-title">Lions</div>
                        <div class="card-text">Discover the majestic lions in their specially designed habitat, showcasing their natural behaviors and social structures.</div>
                    </div>
                </div>
                <div class="card">
                    <img src="../../images/panda.png" alt="Giant Pandas">
                    <div class="card-content">
                        <div class="card-title">Giant Pandas</div>
                        <div class="card-text">Meet our famous giant pandas and learn about their conservation efforts and the challenges they face in the wild.</div>
                    </div>
                </div>
                <div class="card">
                    <img src="../../images/elephant1.jpg" alt="Asian Elephants">
                    <div class="card-content">
                        <div class="card-title">Asian Elephants</div>
                        <div class="card-text">Experience the grandeur of Asian elephants and understand their importance to the ecosystem and conservation needs.</div>
                    </div>
                </div>
            </div>
        </section>

        <section style="margin-top: 100px;">
            <h2 class="section-title">Volunteer with Us</h2>
            <p>Join our dedicated team of volunteers to help care for our animals and educate the public. Fill out our registration form to become a community member and assist with scheduled events.</p>
            <a href="http://localhost/zooparc/pages/auth.php" class="btn btn-success">Register as a Volunteer</a>
        </section>


    </div>

    <div class="cta">
        <h2>Get Involved</h2>
        <p>Want to support our mission? Learn how you can contribute to wildlife conservation and education.</p>
        <a href="">Contact Us</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
