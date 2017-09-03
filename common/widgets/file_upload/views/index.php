<?php
/**
 * @see Yii中文网  http://www.yii-china.com
 * @author Xianan Huang <Xianan_huang@163.com>
 * 图片上传组件
 * 如何配置请到官网（Yii中文网）查看相关文章
 */
 
use yii\helpers\Html;
?>
<div class="per_upload_con" data-url="<?=$config['serverUrl']?>">
    <div class="per_real_img <?=$attribute?>" domain-url = "<?=$config['domain_url']?>"><?=isset($inputValue)?'<img src="'.$config['domain_url'].$inputValue.'">':''?></div>
    <div class="per_upload_img"><?php echo Yii::t('common', 'select picture')?></div>
    <div class="per_upload_text">
        <p class="upbtn" ><a id="<?=$attribute?>" href="javascript:;" class="btn btn-success green choose_btn"><?php echo Yii::t('common', 'select picture')?></a></p>
        <p class="rule"><?php echo Yii::t('common', 'File format only')?> jpg、jpeg、png <?php echo Yii::t('common', 'and')?> gif<br><?php echo Yii::t('common', 'Size below 1MB file')?></p>
    </div>
    <input up-id="<?=$attribute?>" type="hidden" name="<?=$inputName?>" upname='<?=$config['fileName']?>' value="<?=isset($inputValue)?$inputValue:''?>" filetype="img" />
</div>