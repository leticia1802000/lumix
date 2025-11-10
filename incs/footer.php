<!-- FOOTER MAIOR E COMPLETO -->
<footer>
    <style>
        footer {
            background: linear-gradient(90deg, #634996, #4f46e5);
            padding: 60px 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(8px);
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        @media (min-width: 768px) {
            .footer-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        .footer-section h3 {
            font-size: 1.2rem;
            margin-bottom: 1rem;
            color: #fff;
        }

        .footer-section p,
        .footer-section li,
        .footer-section input {
            font-size: 0.95rem;
            color: rgba(255, 255, 255, 0.8);
        }

        .footer-section ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-section ul li {
            margin-bottom: 0.5rem;
        }

        .footer-section ul li a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-section ul li a:hover {
            color: #ffffff;
        }

        .social-icons {
            display: flex;
            gap: 12px;
            margin-top: 10px;
        }

        .social-icons a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transition: all 0.3s ease;
        }

        .social-icons a:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.1);
        }

        footer p.copy {
            text-align: center;
            color: rgba(255, 255, 255, 0.5);
            margin-top: 40px;
            font-size: 0.9rem;
        }
    </style>
        <div class="footer-grid">
            <div class="footer-section">
                <h3>Sobre a Lumix</h3>
                <p>A Lumix conecta fãs e artistas em uma comunidade vibrante dedicada à música. Descubra, compartilhe e viva o som.</p>
            </div>

           

            <div class="footer-section">
                <h3>Suporte</h3>
                <ul>
                    <li>@leticiamacalina</li>
                     <li>@amandascatollin</li>
                 
                </ul>
            </div>

            <div class="footer-section">
                <h3>Redes Sociais</h3>
                <div class="social-icons">
                    <a href="https://www.instagram.com/lumix.me" target="_blank"><i class="fab fa-instagram"></i></a>

                </div>
            </div>
        </div>

        <p class="copy">© 2025 Lumix — Conectando o mundo pela música.</p>

</footer>