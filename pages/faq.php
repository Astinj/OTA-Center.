<h1>FAQ</h1>
<p>
    This page details the most commonly asked questions about the OTA Update Center.<br />
    If you have any further questions, feel free to <a href="?page=irc">contact us</a>.
</p>

<h3>User FAQ</h3>
<ul>
    <li>
        <h4><b>How can I use this updater?</b></h4>
        If your ROM Developer is using our update center app,
        you will automatically receive notifications
        when there is an update available for your ROM.<br />
        If your ROM Developer is not using our update center app,
        then unfortunately there is not much you can do except bug them (kindly) to use it.
    </li>
    <li>
        <h4><b>I downloaded and installed the app, but it doesn't work!!!</b></h4>
        If you download our app after installing the ROM, you're doing it wrong!<br />
        A ROM which uses our update center has the app installed by default,
        so there is no need for you to download and install it manually.<br />
        If you are using a ROM which does not use our update center,
        then downloading and installing this app is useless.
        It cannot and will not magically update your rom, or make unicorn dust fall out of the sky.
    </li>
    <li>
        <h4><b>I don't like your installer. I want to flash the update zip with ROM Manager.</b></h4>
        That is fine. But please tell us why you don't like our installer.<br />
        Then you can go and install the zip just like any other zip from ROM Manager.<br />
        The app downloads the zip file to <code>/sdcard/OTA-Updater/download/romid_device_version.zip</code>.
    </li>
</ul>

<h3>Developer FAQ</h3>
<ul>
    <li>
        <h4><b>How can I use this updater?</b></h4>
        <ol>
            <li>Download the latest version of the app from
            <a href="https://github.com/Vetruvet/ota-update-centre/downloads" target="_blank">our GitHub page</a>.</li>
            <li>Put the app in <code>/system/app</code> of your ROM.</li>
            <li>Pick a ROM ID that you will use in our database. This should have no spaces and preferably be all-lowercase.</li>
            <li>Add the following properties to your build.prop:<br >
                <pre>
otaupdater.otaid=&lt;ROM ID you picked from previous step&gt;
otaupdater.otatime=&lt;Date/time of this build in yyyymmdd-hhmm format&gt;
otaupdater.otaver=&lt;The human-readable version number/name&gt;
                </pre>
            </li>
            <li>Package your ROM, generate an MD5 of the zip file, and upload it somewhere.</li>
            <li>Add/update your ROM in our database. You will need the ROM ID you picked, the device you packaged for, and the URL and MD5 of the zip file.</li>
            <li>For further updates, just make sure you update the otatime and otaver properties in build.prop</li>
        </ol>
    </li>
    <li>
        <h4><b>What are the requirements to use this updater?</b></h4>
        Obviously, your ROM needs to be able to connect to the internet...
        If your rom has no radio/wifi, then this will of course not work.<br />
        It is preferable to have the Play Store included in your ROM.
        This way, the app will use the more efficient push notifications mechanism to deliver updates.<br />
        Even if you do not have the Play Store, the app will still work.
        It will just use pull notifications instead.
    </li>
    <li>
        <h4><b>My users are not getting their updates!</b></h4>
        Make sure the ROM ID in your build.prop matches the one in our database.<br />
        If that is correct, then you can try force-sending the update notification.
        Up-to-date users will not be bothered by the notification anyway.<br />
        If you do not have the Play Store included in your ROM,
        it may take up to 24 hours for your users to get the notification,
        depending on when their device pulls the information from our servers.
    </li>
    <li>
        <h4><b>Your app doesn't work on device X.</b></h4>
        First off, please make sure you are using the latest version of our app!<br />
        We have a very limited number of devices to test on, so we depend on you to give us feedback.
        If you encounter issues with our app, please file a bug report on
        <a href="https://github.com/Vetruvet/ota-update-centre/issues" target="_blank">out GitHub page</a>.<br />
        Please include the device, app version, ROM ID, a description of the issue and any other relevant details.
        If the app crashes, please also attach a logcat.<br />
        We appreciate the feedback!!
    </li>
</ul>