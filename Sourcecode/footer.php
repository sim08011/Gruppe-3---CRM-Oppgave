<footer >
    <!-- Seksjon for informasjon om skole og gruppe -->
    <section class="info">
        <p>&copy; CRM Oppgave Gruppe 3</p>
        <p>2ITA Porsgrunn VGS</p>
    </section>

    <!-- Seksjon for utviklere -->
    <section class="developers">
        <h4>Laget av:</h4>
        <!-- Delseksjon for hver utvikler med navn og lenke til portefølje -->
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

/* Stil for seksjonene i footeren */
footer section {
    padding-right: 10px;
}

/* Stil for lenker i footeren */
footer a {
    margin-top: 0px;
}

/* Stil for utviklerseksjonen */
.developers {
    display: flex;
    justify-content: center;
    align-items: center;
}

/* Stil for hver enkelt utvikler */
.developer {
    margin-right: 10px;
}

/* Stil for siste utvikler i listen */
.developer:last-child {
    margin-right: 0;
}

/* Stil for informasjonsseksjonen */
.info {
    text-align: center;
}

/* Stil for overskriften "Laget av:" */
.developers h4 {
    padding-right: 10px;
}
</style>
