<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expedia-like Layout</title>
    <link rel="stylesheet" href="./css/reservar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

    <header class="navbar">
        <div class="navbar-left">
            <a href="#" class="navbar-logo">Expedia</a>
            <nav class="navbar-menu">
                <ul>
                    <li><a href="#">Shop travel <i class="fas fa-chevron-down"></i></a></li>
                </ul>
            </nav>
        </div>
        <div class="navbar-right">
            <ul>
                <li><a href="#">USD <i class="fas fa-chevron-down"></i></a></li>
                <li><a href="#"><img src="https://flagcdn.com/us.svg" alt="US Flag" class="flag-icon"></a></li>
                <li><a href="#">List your property</a></li>
                <li><a href="#">Support</a></li>
                <li><a href="#">Trips</a></li>
                <li><a href="#"><i class="fas fa-bell"></i></a></li>
                <li><a href="#"><i class="fas fa-user-circle"></i> Sign in</a></li>
            </ul>
        </div>
    </header>

    <section class="hero-section">
        <div class="hero-content">
            <h1>Made to Travel</h1>
            <div class="search-form-container">
                <div class="search-tabs">
                    <button class="tab-button active">
                        <i class="fas fa-bed"></i> Stays
                    </button>
                    <button class="tab-button">
                        <i class="fas fa-plane"></i> Flights
                    </button>
                    <button class="tab-button">
                        <i class="fas fa-car"></i> Cars
                    </button>
                    <button class="tab-button">
                        <i class="fas fa-box"></i> Packages
                    </button>
                    <button class="tab-button">
                        <i class="fas fa-utensils"></i> Things to do
                    </button>
                    <button class="tab-button">
                        <i class="fas fa-ship"></i> Cruises
                    </button>
                </div>
                <form class="search-form">
                    <div class="form-row">
                        <div class="input-group">
                            <label for="destination">Where to?</label>
                            <input type="text" id="destination" placeholder="Going to">
                        </div>
                        <div class="input-group">
                            <label for="dates">Dates</label>
                            <input type="text" id="dates" value="Jul 17 - Jul 22" readonly>
                        </div>
                        <div class="input-group">
                            <label for="travelers">Travelers</label>
                            <input type="text" id="travelers" value="2 travelers, 1 room" readonly>
                        </div>
                        <button type="submit" class="search-button">Search</button>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" id="bundle-save">
                        <label for="bundle-save">Add a flight to bundle & Save</label>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <section class="hotel-listings-section">
        <div class="listings-header">
            <h2>Save up to 40%: Book by July 21</h2>
            <p>Showing deals for Aug 1 - Aug 3</p>
            <button class="see-more-button">See more deals</button>
        </div>
        <div class="hotel-cards-container">
            <div class="hotel-card">
                <img src="https://via.placeholder.com/300x200/e0e0e0/ffffff?text=Hotel+Image+1" alt="Alrazi Hotel" class="hotel-image">
                <div class="hotel-info">
                    <div class="hotel-rating">8.0 Very Good (98 reviews)</div>
                    <h3 class="hotel-name">Alrazi Hotel</h3>
                    <p class="hotel-location">Istanbul</p>
                    <div class="hotel-price">
                        <span class="current-price">$198 nightly</span>
                        <span class="old-price">$260</span>
                    </div>
                    <p class="taxes-info">total with taxes and fees</p>
                    <button class="member-price-button"><i class="fas fa-lock"></i> Member Price available</button>
                </div>
            </div>

            <div class="hotel-card">
                <img src="https://via.placeholder.com/300x200/d0d0d0/ffffff?text=Hotel+Image+2" alt="Divan Istanbul" class="hotel-image">
                <div class="hotel-info">
                    <div class="hotel-rating">9.2 Wonderful (114 reviews)</div>
                    <h3 class="hotel-name">Divan Istanbul</h3>
                    <p class="hotel-location">Istanbul</p>
                    <div class="hotel-price">
                        <span class="current-price">$385 nightly</span>
                        <span class="old-price">$614</span>
                    </div>
                    <p class="taxes-info">total with taxes and fees</p>
                    <button class="member-price-button"><i class="fas fa-lock"></i> Member Price available</button>
                </div>
            </div>

            <div class="hotel-card">
                <img src="https://via.placeholder.com/300x200/c0c0c0/ffffff?text=Hotel+Image+3" alt="Baglioni Hotel Regina" class="hotel-image">
                <div class="hotel-info">
                    <div class="hotel-rating">9.0 Wonderful (463 reviews)</div>
                    <h3 class="hotel-name">Baglioni Hotel Regina</h3>
                    <p class="hotel-location">Rome</p>
                    <div class="hotel-price">
                        <span class="current-price">$1,491 nightly</span>
                        <span class="old-price">$1,894</span>
                    </div>
                    <p class="taxes-info">total with taxes and fees</p>
                    <button class="member-price-button"><i class="fas fa-lock"></i> Member Price available</button>
                </div>
            </div>

            <div class="hotel-card">
                <img src="https://via.placeholder.com/300x200/b0b0b0/ffffff?text=Hotel+Image+4" alt="Trademark Collection by Wyndham" class="hotel-image">
                <div class="hotel-info">
                    <div class="hotel-rating">8.9 Very Good (43 reviews)</div>
                    <h3 class="hotel-name">Trademark Collection by Wyndham</h3>
                    <p class="hotel-location">Amaoudby</p>
                    <div class="hotel-price">
                        <span class="current-price">$349 nightly</span>
                        <span class="old-price">$419</span>
                    </div>
                    <p class="taxes-info">total with taxes and fees</p>
                    <button class="member-price-button"><i class="fas fa-lock"></i> Member Price available</button>
                </div>
            </div>
        </div>
    </section>

</body>
</html>