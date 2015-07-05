<?php
/**
 *  @package AkeebaSubs
 *  @copyright Copyright (c)2010-2015 Nicholas K. Dionysopoulos
 *  @license GNU General Public License version 3, or later
 */

defined('_JEXEC') or die();

use \Akeeba\Subscriptions\Admin\Helper\ComponentParams;
use \Akeeba\Subscriptions\Admin\Helper\Image;
use \Akeeba\Subscriptions\Admin\Helper\Message;

/** @var \Akeeba\Subscriptions\Site\View\Levels\Html $this */

?>

<div id="akeebasubs" class="levels">

<?php echo $this->getContainer()->template->loadPosition('akeebasubscriptionslistheader')?>

<?php if(!empty($this->items)) foreach($this->items as $level):?>
<?php
	$priceInfo = $this->getLevelPriceInformation($level);
?>
	<div class="level akeebasubs-level-<?php echo $level->akeebasubs_level_id ?>">
		<p class="level-title">
			<span class="level-price">
				<?php if($this->renderAsFree && ($priceInfo->levelPrice < 0.01)):?>
				<?php echo JText::_('COM_AKEEBASUBS_LEVEL_LBL_FREE') ?>
				<?php else: ?>
				<?php if(ComponentParams::getParam('currencypos','before') == 'before'): ?>
				<span class="level-price-currency"><?php echo ComponentParams::getParam('currencysymbol','€')?></span>
				<?php endif; ?>
				<span class="level-price-integer"><?php echo $priceInfo->priceInteger ?></span><?php if((int)$priceInfo->priceFractional > 0): ?><span class="level-price-separator">.</span><span class="level-price-decimal"><?php echo $priceInfo->priceFractional ?></span><?php endif; ?>
				<?php if(ComponentParams::getParam('currencypos','before') == 'after'): ?>
				<span class="level-price-currency"><?php echo ComponentParams::getParam('currencysymbol','€')?></span>
				<?php endif; ?>
				<?php endif; ?>
				<?php if (((float)$priceInfo->vatRule->taxrate > 0.01) && ($priceInfo->levelPrice > 0.01)): ?>
					<span class="level-price-taxnotice">
						<?php echo JText::sprintf('COM_AKEEBASUBS_LEVELS_INCLUDESVAT', (float)$priceInfo->vatRule->taxrate); ?>
					</span>
				<?php endif; ?>
			</span>
			<span class="level-title-text">
				<a href="<?php echo JRoute::_('index.php?option=com_akeebasubs&view=level&slug='.$level->slug.'&format=html&layout=default')?>">
					<?php echo $this->escape($level->title)?>
				</a>
			</span>
		</p>
		<div class="level-inner">
			<div class="level-description">
				<div class="level-description-inner">
					<?php if(!empty($level->image)):?>
					<img class="level-image" src="<?php echo Image::getURL($level->image)?>" />
					<?php endif;?>

					<?php if(abs($priceInfo->signupFee) >= 0.01):?>
					<b><?php echo JText::_('COM_AKEEBASUBS_LEVEL_FIELD_SIGNUPFEE_LIST'); ?></b>
					<?php if(ComponentParams::getParam('currencypos','before') == 'before'): ?>
					<span class="level-price-currency"><?php echo ComponentParams::getParam('currencysymbol','€')?></span>
					<?php endif; ?>
					<span class="level-price-integer"><?php echo $priceInfo->signupInteger ?></span><?php if((int)$priceInfo->signupFractional > 0): ?><span class="level-price-separator">.</span><span class="level-price-decimal"><?php echo $priceInfo->signupFractional ?></span><?php endif; ?>
					<?php if(ComponentParams::getParam('currencypos','before') == 'after'): ?>
					<span class="level-price-currency"><?php echo ComponentParams::getParam('currencysymbol','€')?></span>
					<?php endif; ?>
					<br/>
					<?php endif; ?>

					<?php echo JHTML::_('content.prepare', Message::processLanguage($level->description));?>
				</div>
			</div>
			<div class="level-clear"></div>
			<div class="level-subscribe">
				<button onclick="window.location='<?php echo JRoute::_('index.php?option=com_akeebasubs&view=level&slug='.$level->slug.'&format=html&layout=default')?>'">
					<?php echo JText::_('COM_AKEEBASUBS_LEVELS_SUBSCRIBE')?>
				</button>
			</div>
		</div>
	</div>
<?php endforeach;?>
<div class="level-clear"></div>

<?php if ($this->showLocalPrices) : ?>
	<div class="akeebasubs-forex-notice">
		<p>
			<?php echo JText::sprintf('COM_AKEEBASUBS_LEVELS_FOREXNOTICE',
				$this->localCurrency, $this->localSymbol,
				ComponentParams::getParam('currency','EUR'),
				$this->exchangeRate); ?>
		</p>
	</div>
<?php endif; ?>

<?php echo $this->getContainer()->template->loadPosition('akeebasubscriptionslistfooter')?>
</div>