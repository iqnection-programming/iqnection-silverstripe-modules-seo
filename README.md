# iqnection-silverstripe-3-modules-seo
SilverStripe 3 SEO Module
<h2>Important Note</h2>
<p>Your Page class (Page.php) <em>must</em> have the following added:</p>
<pre>
public function onBeforeWrite()
{
	$this->extend('hook_onBeforeWrite', $this);
	parent::onBeforeWrite();
}
</pre>
