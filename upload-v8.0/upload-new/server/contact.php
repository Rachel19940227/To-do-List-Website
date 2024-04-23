<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Meta tags for character set, index information, and page title -->
        <meta charset="utf-8">
        <meta name="index" content="index">
        <title>index</title>
        <!-- add meta and title to this page -->
    </head>
    <body>
    <?php include ("header.php") ?>
    <!-- Main content section -->
    <div class="column">
                    <div class="contact-container">
                        <form id="contact" action="Assignment2" method="post">
                            
                            <h2>CONTACT US</h2>
                            <fieldset>
                                <input placeholder="Your name" type="text" tabindex="1" required autofocus>
                            </fieldset>
                            <fieldset>
                                <input placeholder="Your Email Address" type="email" tabindex="2" required>
                            </fieldset>
                            <fieldset>
                                <input placeholder="Your Phone Number" type="tel" tabindex="3" required>
                            </fieldset>
                            <fieldset>
                                <textarea placeholder="Type your Message Here...." tabindex="5" required></textarea>
                            </fieldset>
                            <fieldset>
                                <button name="submit" type="submit" id="contact-submit"
                                    data-submit="...Sending">Submit</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Footer section -->
            <?php include("footer.php"); ?>
        </div>
    </body>
</html>