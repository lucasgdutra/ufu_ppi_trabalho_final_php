    <footer class="fixed-bottom text-center bg-light">
        Trabalho de programação para internet feito por: Guilherme Castilho e
        Lucas Souza
    </footer>
    <script src="/js/bootstrap.bundle.min.js"></script>
    <?php
    if (isset($scripts) && is_array($scripts)) {
        foreach ($scripts as $script) {
            echo "<script src='{$script}'></script>";
        }
    }
    ?>
</body>

</html>