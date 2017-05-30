<?php

namespace Box\Spout\Writer\Common\Creator\Style;

use Box\Spout\Writer\Common\Entity\Style\Border;
use Box\Spout\Writer\Common\Entity\Style\Color;
use Box\Spout\Writer\Common\Manager\Style\StyleMerger;

/**
 * Class StyleManagerTest
 *
 * @package Box\Spout\Writer\Common\Creator\Style
 */
class StyleBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return void
     */
    public function testStyleBuilderShouldApplyBorders()
    {
        $border = (new BorderBuilder())
            ->setBorderBottom()
            ->build();
        $style = (new StyleBuilder())->setBorder($border)->build();
        $this->assertTrue($style->shouldApplyBorder());
    }

    /**
     * @return void
     */
    public function testStyleBuilderShouldMergeBorders()
    {
        $border = (new BorderBuilder())->setBorderBottom(Color::RED, Border::WIDTH_THIN, Border::STYLE_DASHED)->build();

        $baseStyle = (new StyleBuilder())->setBorder($border)->build();
        $currentStyle = (new StyleBuilder())->build();

        $styleMerger = new StyleMerger();
        $mergedStyle = $styleMerger->merge($currentStyle, $baseStyle);

        $this->assertEquals(null, $currentStyle->getBorder(), 'Current style has no border');
        $this->assertInstanceOf('Box\Spout\Writer\Common\Entity\Style\Border', $baseStyle->getBorder(), 'Base style has a border');
        $this->assertInstanceOf('Box\Spout\Writer\Common\Entity\Style\Border', $mergedStyle->getBorder(), 'Merged style has a border');
    }
}
