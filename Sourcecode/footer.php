<footer >
<section class="info">
        <p>&copy; CRM Oppgave Gruppe 3</p>
        <p>2ITA Porsgrunn VGS</p>
    </section>

    <section class="developers">
        <h4>Laget av:</h4>
        <section class="developer">
            <p>Sondre Thorsen</p>
            <a href="https://im22son21061.imporsgrunn.no" target="_blank">Portfolio</a>
        </section>
        <section class="developer">
            <p>Simon Johnsen</p>
            <a href="https://im22sim08011.imporsgrunn.no"  target="_blank">Portfolio</a>
        </section>
        <section class="developer">
            <p>Teodor Follaug</p>
            <a href="https://im22teo23062.imporsgrunn.no"  target="_blank">Portfolio</a>
        </section>
   </section>

</footer>


<style>
html {
    height: 100%;
    box-sizing: border-box;
}

*, *::before, *::after {
    box-sizing: inherit;
}

body {
    margin: 0;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

main {
    flex: 1;
}

footer {
    flex-shrink: 0;
    background-color: #333;
    color: #fff;
    text-align: center;
    padding: 10px 0;
}

    footer section {
        padding-right: 10px;
    }
    footer a {
        margin-top: 0px;
    }

    .developers {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .developer {
        margin-right: 10px;
    }

    .developer:last-child {
        margin-right: 0;
    }

    .info {
        text-align: center;
    }

    .developers h4 {
        padding-right: 10px;
    }
</style>