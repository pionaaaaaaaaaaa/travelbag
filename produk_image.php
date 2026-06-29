<?php
/**
 * Helper: Render product image
 * Usage: renderProdukImage($produk['gambar'], $produk['nama'], $class)
 */
function renderProdukImage($gambar, $nama = '', $class = '', $style = '') {
    $path = 'assets/images/produk/' . $gambar;
    // Change .jpg/.png to .svg
    $svgPath = preg_replace('/\.(jpg|jpeg|png)$/i', '.svg', $path);
    
    if ($class) $classAttr = ' class="' . htmlspecialchars($class) . '"';
    else $classAttr = '';
    
    if ($style) $styleAttr = ' style="' . htmlspecialchars($style) . '"';
    else $styleAttr = '';
    
    return '<img src="' . $svgPath . '" alt="' . htmlspecialchars($nama) . '"' . $classAttr . $styleAttr . ' onerror="this.style.display=\'none\'; this.nextElementSibling.style.display=\'flex\';">';
}
?>
