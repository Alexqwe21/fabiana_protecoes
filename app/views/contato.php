<!DOCTYPE html>
<html lang="pt-br">

<?php require('head/head.php'); ?>


<?php require_once('template/header.php') ?>

<body>

    <?php require_once('musica.php') ?>
    <main>
        <section class="banner-pagina">
            <article class="site">
                <hr>
                <h2>Contato</h2>
                <h3> <a href="index.html">Início</a> <strong>/ Contato</strong></h3>
            </article>
        </section>


        <section class="contato">
            <article class="site">
                <!-- certeza -->
                <div class="entrar-em-contato">
                    <div class="contato-icones">
                        <hr>
                        <h2>Entrar em Contato</h2>
                        <div>
                            <img src="/assets/img/contato-telefone.svg" alt="img">
                            <p>11-977034880</p>
                        </div>
                        <div>
                            <img src="/assets/img/contato-email.svg" alt="img">
                            <p> Fabidaprotecao@fabidaprotecaoveicular.com.br
                            </p>
                        </div>
                        <div>
                            <img src="/assets/img/contato-localizacao.svg" alt="img">
                            <p>Avenida Marechal Tito, 1.753 - São Miguel</p>
                        </div>
                    </div>

                    <div class="formulario">
                        <form action="https://formsubmit.co/fabiprotecoes@hotmail.com" method="post">
                            <input type="hidden" name="_subject" value="Nova mensagem enviada pelo formulário">
                            <input type="hidden" name="_captcha" value="false">
                            <input type="hidden" name="_autoresponse"
                                value="Obrigado! Recebemos sua mensagem e entraremos em contato em breve.">

                            <div class="form-group">
                                <input type="text" id="nome" name="Nome" placeholder="Seu Nome" required>
                            </div>
                            <div class="form-group">
                                <input type="email" id="email" name="E-mail" placeholder="Seu E-mail" required>
                            </div>
                            <div class="form-group">
                                <input type="text" id="assunto" name="Assunto" placeholder="Assunto" required>
                            </div>
                            <div class="form-group">
                                <textarea id="mensagem" name="Mensagem" placeholder="Deixe sua mensagem aqui"
                                    required></textarea>
                            </div>
                            <button type="submit" class="btn01">Enviar mensagem</button>
                        </form>


                    </div>


                </div>


            </article>

        </section>

        <section class="mapa">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3659.0431785671544!2d-46.428810299999995!3d-23.4949542!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94ce63c2b920d321%3A0xae4a9a2da6a5207c!2sAvenida%20Marechal%20Tito%2C%201.753%20-%20S%C3%A3o%20Miguel%20Paulista%2C%20S%C3%A3o%20Paulo%20-%20SP%2C%2008022-000!5e0!3m2!1spt-BR!2sbr!4v1732638510144!5m2!1spt-BR!2sbr"
                width="1920" height="500" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </section>

    </main>











    <?php require_once('template/footer.php'); ?>


    <?php require('script/script.php'); ?>




</body>





</html>