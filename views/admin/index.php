<?php

use yii\bootstrap\Nav;

/* @var $this yii\web\View */
?>
<h1><?php echo Yii::t('app', 'Administrative area');?></h1>
<div class="row">
	<div class="col-md-3">
		<?php
			echo Nav::widget([
				'items' => [
					[
						'label' => Yii::t('app', 'Categories'),
						'url' => ['categories/index']
					],
					[
						'label' => Yii::t('app', 'Articles'),
						'url' => ['articles/index']
					],
					[
						'label' => Yii::t('app', 'Menu'),
						'url' => ['menu/index']
					],
					[
						'label' => Yii::t('app', 'Settings'),
						'url' => ['settings/index']
					],
				]
			]);
		?>
	</div>
	<div class="col-md-9">

	</div>
</div>