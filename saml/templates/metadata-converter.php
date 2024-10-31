<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
$this->data['header'] = $this->t('metaconv_title');
$this->includeAtTemplateBase('includes/header.php');
?>
    <h2><?php echo $this->t('metaconv_title'); ?></h2>
    <form action="?" method="post" enctype="multipart/form-data">
        <p><?php echo($this->t('{admin:metaconv_xmlmetadata}')); ?></p>
        <p>
            <textarea rows="20" style="width: 100%"
                      name="xmldata"><?php echo htmlspecialchars($this->data['xmldata']); ?></textarea>
        </p>
        <p>
            <?php echo $this->t('metaconv_selectfile'); ?>
            <input type="file" name="xmlfile" /></p>
        <p>
            <button type="submit" class="btn"><?php echo $this->t('metaconv_parse'); ?></button>
        </p>
    </form>
<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
$output = $this->data['output'];

if (!empty($output)) {
?>
    <h2><?php echo $this->t('metaconv_converted'); ?></h2>
<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    $i = 1;
    foreach ($output as $type => $text) {
        if ($text === '') {
            continue;
        }
?>
    <h3><?php echo htmlspecialchars($type); ?></h3>
    <div class="metadatabox">
        <button data-clipboard-target="#metadata<?php echo $i; ?>" id="btn<?php echo $i; ?>"
                class="btn topright" style="margin-right: 0.5em;">
            <img src="/<?php echo $this->data['baseurlpath'].'resources/icons/clipboard.svg'; ?>"
                 alt="Copy to clipboard" />
        </button>
        <pre id="metadata<?php echo $i; ?>"><?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
            echo htmlspecialchars($text);
        ?></pre>
    </div>
<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
        $i++;
    }
?>
    <script type="text/javascript">
<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    for ($j = 1; $j <= $i; $j++) {
?>
        var clipboard<?php echo $j; ?> = new Clipboard('#btn<?php echo $j; ?>');
<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    }
 ?>
    </script>
<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
}
$this->includeAtTemplateBase('includes/footer.php');
