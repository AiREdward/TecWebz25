
<nav aria-label="breadcrumb" class="breadcrumb-container">
    <p>Ti trovi in:
        <?php
        $breadcrumb = isset($breadcrumb) ? $breadcrumb : [];

        foreach ($breadcrumb as $key => $item) {
            if ($key === array_key_last($breadcrumb)) {
                echo '<span class="active">' . htmlspecialchars($item['name']) . '</span>';
            } else {
                echo '<a href="' . htmlspecialchars($item['url']) . '">' . htmlspecialchars($item['name']) . '</a> > ';
            }
        }
        ?>
    </p>
</nav>