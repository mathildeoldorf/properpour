<?php
$sTitle = ' | Front page';
$sCurrentPage = 'frontpage';
require_once(__DIR__ . '/components/header.php');
?>

<main class="frontpage">

    <section class="section-one grid grid-almost-two mb-large">
        <div class="align-items-center pl-large relative">
            <div class="banner-text-container absolute">
                <div class="logo">
                    <h1>Welcome</h1>
                </div>
                <h2 class="mt-small">Enhance your everyday coffee experience.</h2>
                <!-- <h2 class="">Freshly roasted, quality coffee at your doorstep.</h2> -->
                <p class="banner-message align-self-top pt-small pr-large">
                Freshly roasted, quality coffee at your doorstep
                </p>
                <p class="banner-message align-self-top pv-small pr-large">
                    Let us help you find <strong>your</strong> proper pour -  tailormade to your tastebuds.
                </p>

                <a href="#test">
                    <button class="button mt-small toTest">Get matched</button>
                </a>
            </div>
        </div>
        <div class="gridForAboveTheFold">
            <div class=" image-container bg-light-brown box1">
                <div class="image bg-contain img1"></div>
            </div>
            <div class="image-container bg-brown box2">
                <div class="image bg-contain img2"></div>
            </div>
            <div class="image-container bg-medium-light-brown box3">
                <div class="image bg-contain img3"></div>
            </div>
            <div class="image-container bg-dark-brown box4">
                <div class="image bg-contain img4"></div>
            </div>
        </div>
    </section>

    <section class="section-two grid mb-large">
        <h2 class="mb-small">What you get</h2>
        <h3 class="mb-small">We make sure you get everything you wish for and more </h3>
        <div class="grid grid-two-thirds-reversed ph-xlarge whatGetSection">
            <div class="image bg-contain"></div>
            <div class="colorBlock">

                <div class="list p-medium">
                    <div>
                        <h4 class="">Coffee</h4>
                        <p>Your handpicked selection of coffee</p>
                    </div>
                    <div>
                        <h4 class="">Tips</h4>
                        <p>Tasting notes and brewing tips</p>
                    </div>
                    <div>
                        <h4 class="">Experience</h4>
                        <p>Coffee tailormade to your taste - everyday</p>
                    </div>
                    <a href="subscribe">
                        <button class="button">Subscribe </button>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="section-three grid">
        <h2 class="mb-small">How it works</h2>
        <h3 class="mb-small">Enhancing your everyday coffee experience has never been easier</h3>
        <div class="grid grid-three container">
            <div class="flipcontainer" ontouchstart="this.classList.toggle('hover');">
                <div class="flipper">
                    <div class="front step one bg-light-brown">
                        <div class="step-no absolute">
                            <h4 class="color-white relative">Step</h4>
                            <div class="no relative">1</div>
                        </div>
                        <div class="image bg-contain"></div>
                        <div class="description">

                            <h4 class="color-white">Select your coffee of choice from our wide selection</h4>
                        </div>
                    </div>
                    <div class="back p-medium ph-medium pv-medium">

                        <h4 class="pb-small">We have 6 types of subscription</h4>

                        <p class="p-small">To make sure our subscriptions fit your taste, we've created 6 different subscriptions. 
                        If you are in doubt of which to choose, go ahead and take our test for a tailormade recommendation.</p>
                        <a href="subscribe" class="grid">
                        <button class="button mt-small justify-self-center grid">Subscribe </button>
                        </a>

                    </div>
                </div>
            </div>
            <div class="flipcontainer" ontouchstart="this.classList.toggle('hover');">
                <div class="flipper">
                    <div class="front step two bg-medium-light-brown">
                        <div class="step-no absolute">
                            <h4 class="color-white relative">Step</h4>
                            <div class="no relative">2</div>
                        </div>
                        <div class="image bg-contain"></div>
                        <div class="description">
                            <h4 class="color-white">Create an account and proceed to check out</h4>
                        </div>
                    </div>
                    <div class="back p-medium ph-medium pv-medium">
                        <h4 class="pb-small">Create a user profile and get a discount</h4>
                        <p class="p-small">We take our users sensitive data very seriously, that is why we highly recommend you to create a profile and we will protect your data. Also as a new user you get a discount from us as a welcome gift! </p>
                    </div>
                </div>
            </div>
            <div class="flipcontainer" ontouchstart="this.classList.toggle('hover');">
                <div class="flipper">
                    <div class="front step three bg-dark-brown">
                        <div class="step-no absolute">
                            <h4 class="color-white relative">Step</h4>
                            <div class="no relative">3</div>
                        </div>
                        <div class="image bg-contain"></div>
                        <div class="description">
                            <h4 class="color-white">Enjoy freshly roasted, quality coffee - everyday</h4>
                        </div>
                    </div>
                    <div class="back p-medium ph-medium pv-medium">
                            <h4 class="pb-small">We deliver as fast as we can</h4>
                        <p class="p-small">We aim to deliver your coffee as soon as possible and the most convineient way. We know how important to get a freshly roasted coffee, that is why we work hard to make your coffee drinking experience as best as possible. </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <h2 class="text-center testHeader mb-small mt-medium" >In doubt about your coffee of choice?</h2>
        <h3 class="text-center mb-small" >Get a personal recommendation by taking our coffee test</h3>
        <a href="#test"><button id="startBtn" class="button">Get matched</button>
        </a>

        <div id="test" class="testContainer hide margin-auto mt-small mb-large">
            <div class="testbg container-banner bg-brown"></div>
            <div class="intro">
            </div>
            <div class="testContent">
            <h1 id="timeline"></h1>

            <h2 id="question" class="pb-small"></h2>
            <h3 id="questionText"></h3>
            <div id="answer"></div>
            </div>
            <div class="testButtons">
            <button id="backBtn" class="button">Back</button>
        </div>
        </div>

    <section class="section-four grid mt-large mb-large">
        <h2 class="mb-small">Why choose The Proper Pour</h2>
        <h3 class="mb-small">Get ready to have all your expectations met</h3>
        <div class="grid grid-two container ph-xlarge bg-medium-light-brown height90">
            <div class="colorBlock1 ">
                <div class="list1 list p-medium">
                    <div>
                        <h4 class="">No binding</h4>
                        <p>You can stop your subscription anytime</p>
                    </div>
                    <div>
                        <h4 class="">Tailormade taste</h4>
                        <p>Designed test helps you to choose the right coffee for you</p>
                    </div>
                    <div>
                        <h4 class="">Coffee discount</h4>
                        <p>Our subscribers have 10% discount for all coffee in our webshop</p>
                    </div>
                    <div>
                        <h4 class="">Free delivery</h4>
                        <p>Delivery is always included in the price</p>
                        <!-- <a href="subscribe"><button class="button margin-auto mt-large" id="btnInside">SUBSCRIBE </button></a> -->
                    </div>
                </div>
            </div>
            <div class="image bg-contain relative cupImage"></div>
        </div>
    </section>

    <section class="section-five grid mb-footer">
        <h2 class="mb-small">Enhance your experience</h2>
        <h3 class="mb-small">Tips and tricks to make your best cup of coffee</h3>
        <div class="grid grid-four container masonry">
            <div class="flipcontainer item one grid" ontouchstart="this.classList.toggle('hover');">
                <div class="flipper">
                    <div class="front bg-dark-brown">
                        <div class="image1 bg-contain"></div>
                        <h4 class="color-white relative text-cente">How to choose coffee</h4>
                    </div>
                    <div class="back p-medium ">


                        <p class="p-smallest"> If you prefer<strong> coffee with a smooth taste </strong>, then look for dry, light coloured coffee beans, which are roasted for a shorter time.
                            If you like a strong, bold cofee, buy beans,that roasted longer.

                        </p>
                        <p class="p-smallest"><strong>Light roasted coffee beans contain the highest level of caffeine </strong>, then medium and then dark roasted. If you are looking for increase your caffeine intake, you are better going for light or medium roasted beans. </p>
                        <p class="p-smallest">Freshness is important, so <strong>check the roast date </strong> the label before buying coffee! If you don’t have a coffee grinder in your house, go for the whole bean bag and ask the supermarket or café to grind them for you.</p>

                    </div>
                </div>
            </div>

            <div class="flipcontainer item two grid" ontouchstart="this.classList.toggle('hover');">
                <div class="flipper">
                    <div class="front bg-for-how">
                        <div class="image1 bg-contain"></div>
                        <h4 class="color-white relative text-cente">How to brew coffee</h4>
                    </div>
                    <div class="back p-medium">
                        <p class="p-smallest">Make sure that <strong>your tools are cleaned and rinsed </strong> hot water. It’s important to check that no grounds have been left to collect and that there’s no build-up of coffee, which can make future cups of coffee taste bitter and rancid.</p>
                        <p class="p-smallest"><strong>Great coffee starts with great beans </strong> the flavour of your coffee is not only determined by your favourite brewing process, but also by the type of coffee you select.</p>
                        <p class="p-smallest"> Buy coffee as soon as possible after it’s roasted. <strong>Fresh-roasted coffee is essential </strong> to a quality cup, so buy your coffee in small amounts (ideally every two weeks).</p>
                        <p class="p-smallest"><strong>The size of the grind is hugely important </strong> to the taste of your coffee. If your coffee tastes bitter, it may be over-extracted, or ground too fine. On the other hand, if your coffee tastes flat, it may be under-extracted, meaning your grind is too rough.</p>


                    </div>
                </div>
            </div>
            <div class="flipcontainer item three grid" ontouchstart="this.classList.toggle('hover');">
                <div class="flipper">
                    <div class="front bg-medium-light-brown">
                        <div class="image1 bg-contain"></div>
                        <h4 class="color-white relative text-cente">Christmas coffee</h4>
                    </div>
                    <div class="back p-medium">
                        <p class="p-smallest">With Christmas around the corner, remember to add it also to your coffee!</p>
                        <p class="p-smallest"> What about some cinnamon, ground cardamom, cloves, nutmeg or whipped cream and marshmallows? <strong>Check out other recipes from our friends from BestRecipies.com/chrismasCoffee! </strong></p>
                    </div>
                </div>
            </div>
            <div class="flipcontainer item four grid" ontouchstart="this.classList.toggle('hover');">
                <div class="flipper">
                    <div class="front bg-for-how">
                        <div class="image1 bg-contain relative"></div>
                        <h4 class="color-white relative text-cente">4 Tips for Serving Good Coffee for a Crowd</h4>
                    </div>
                    <div class="back p-medium">
                        <p class="p-smallest"><strong>Buy good beans</strong>
                            Make sure your guests are happy about what they are drinking</p>
                        <p class="p-smallest"> <strong>Choose a method that works for a crowd</strong>
                            We recommend you buy a large French press, to be sure that you can serve many cups at a time.</p>
                        <p class="p-smallest"><strong>Keep it warm</strong>
                            We recommend you invest in a good thermos if you like long weekend brunches at your home.</p>
                        <p class="p-smallest"> <strong>Have the proper additions at hands</strong>
                            Be sure that milk, sugar and water are on the table!
                        </p>
                    </div>
                </div>
            </div>
            <div class="flipcontainer item five grid" ontouchstart="this.classList.toggle('hover');">
                <div class="flipper">
                    <div class="front bg-medium-light-brown ">
                        <div class="image1 bg-contain "></div>
                        <h4 class="color-white relative text-cente">Best coffee equipment <br> Our choice in 2019</h4>
                    </div>
                    <div class="back p-medium">
                        <p class="p-smallest"> <strong>Home Coffee Grinder </strong> has easily adjustable grind settings, a solid burr set, good solid construction, and overall value for the money.</p>
                        <p class="p-smallest"> <strong>Automatic Brewer </strong>have been some of our favourites for years, mainly because they match great brewing performance with an affordable price.</p>
                        <p class="p-smallest"> <strong> Home Espresso Machine </strong> allows you to fully tweak how your shot pulls, so it is absolutely perfect for espresso nerds like us.</p>
                        <p class="p-smallest"> All these amazing equipment can be bought at our friends’ shop:<strong> friendsshop/shop</strong></p>
                    </div>
                </div>
            </div>

            <div class="flipcontainer item six grid" ontouchstart="this.classList.toggle('hover');">
                <div class="flipper">
                    <div class="front bg-dark-brown">
                        <div class="image1 bg-contain"></div>
                        <h4 class="color-white relative text-cente">3 ways to be a more sustainable coffee drinker</h4>
                    </div>
                    <div class="back p-medium">
                        <p class="p-smallest">Look for <strong>brands that support of sustainable coffee producers and environment </strong>. (All our brands are sustainable!)</p>
                        <p class="p-smallest"> Disposable coffee cups, single-serve capsules and pods are bad for the environment. Try to <strong> avoid disposable, plastic and paper</strong> in your coffee making or at least go for recycled. Check our friends’ tools for coffee making in a sustainable way: <strong>linkToFriends/sustainable</strong></p>
                        <p class="p-smallest"> <strong>Coffee grounds are biodegradable </strong>, which means you can use them to fertilize your plants. If you do not have a garden, make a hair or skin mask!</p>
                    </div>
                </div>
            </div>

        </div>
    </section>

</main>

<script src="js/sessionStorageCart.js"></script>
<script src="js/coffeeTest.js"></script>

<?php
$sScriptPath = 'index.js';
require_once(__DIR__ . '/components/footer.php');
