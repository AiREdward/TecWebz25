
<nav role="navigation" aria-label="breadcrumb" class="breadcrumb-container">
    <section id="breadcrumb-wrapper">
        <p id="breadcrumb-label">Ti trovi in:
            <?php
            $breadcrumb = isset($breadcrumb) ? $breadcrumb : [];

            foreach ($breadcrumb as $key => $item) {
                if ($key === array_key_last($breadcrumb)) {
                    echo '<span class="active" aria-current="page">' . htmlspecialchars($item['name']) . '</span>';
                } else {
                    echo '<a href="' . htmlspecialchars($item['url']) . '">' . htmlspecialchars($item['name']) . '</a> <span class="separator" aria-hidden="true">&gt;</span> ';
                }
            }
            ?>
        </p>
    </section>
</nav>