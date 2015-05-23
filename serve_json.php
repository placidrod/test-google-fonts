<?php

require_once('apikey.php');

/**
* 1. Get JSON Data from url
* 2. Serve Data as requested
*/
class Font
{
	private $url = 'fonts_local.json';

	public function saveFonts()
	{
		// Get the content of JSON file from google api and update fonts_local.json file with the content
		$contents = file_get_contents('https://www.googleapis.com/webfonts/v1/webfonts?key=' . APIKEY);
		try {
			file_put_contents('fonts_local.json', "");
			file_put_contents('fonts_local.json', $contents);
			return true;
		} catch (Exception $e) {
			return false;
		}
	}

	public function getFonts()
	{
		$json = file_get_contents($this->url);
		$obj = json_decode($json, true);
		return $obj['items'];
	}

	public function getAllFontFamily() {
		$fonts = $this->getFonts();
		$fontFamily = [];
		for($i=0; $i<count($fonts); $i++) {
			$fontFamily[] = $fonts[$i]['family'];
		}
		return $fontFamily;
	}

	public function getFontCategories()
	{
		$fonts = $this->getFonts();
		$fontCategories = [];
		for($i=0; $i<count($fonts); $i++) {
			$fontCategories[] = $fonts[$i]['category'];
		}
		return array_unique($fontCategories);		
	}

	public function getFontFamiliesByCategory($cat)
	{
		$fonts = $this->getFonts();
		$fontFamily = [];
		for($i=0; $i<count($fonts); $i++) {
			if($fonts[$i]['category'] == $cat) {
				$fontFamily[] = $fonts[$i]['family'];
			}
		}
		return $fontFamily;
	}

	public function getCategoryByFamily($fontFamily)
	{
		$fonts = $this->getFonts();
		for($i=0; $i<count($fonts); $i++) {
			if($fonts[$i]['family'] == $fontFamily) {
				return $fonts[$i]['category'];
			}
		}
		return false;
	}	

	public function getVariants($selectedFont) {
		$fonts = $this->getFonts();
		$variants = [];

		for($i=0; $i<count($fonts); $i++) {
			if($selectedFont == $fonts[$i]['family']) {
				foreach ($fonts[$i]['variants'] as $variant) {
					$variants[] = $variant;
				}
				return $variants;
			}
		}	
	}

	public function checkForEmptyProperty($property) {
		$fonts = $this->getFonts();
		for($i=0; $i<count($fonts); $i++) {
			if(empty($fonts[$i][$property])) {
				echo "There is an Empty variant";
			}
			print_r($fonts[$i][$property]);
		}
		echo "Check complete";
	}

	public function getUniqueVarients() {
		$fonts = $this->getFonts();
		$variants = [];
		for($i=0; $i<count($fonts); $i++) {
			foreach($fonts[$i]['variants'] as $fontVarient) {
				if(!in_array($fontVarient, $variants)) {
					$variants[] = $fontVarient;
				}
			}
		}
		return $variants;
	}	

}

$font = new font();

$font->saveFonts();


if(isset($_GET['saveFontFile'])) {
	if($font->saveFonts()) {
		echo "Fonts Loaded";
	} else {
		echo "Could not load";
	}
}


if(isset($_GET['familyForVariant'])) {
	$family = $_GET['familyForVariant'];
	$variants = $font->getVariants($family);
	$variantsHtml = '<option value="">Select Varient</option>';
	for($i=0;$i<count($variants);$i++) {
		$variantsHtml .= '<option value="' . $variants[$i] . '">' . $variants[$i] . '</option>';
	}
	echo $variantsHtml;
}

if(isset($_GET['category'])) {
	$category = $_GET['category'];
	$fontFamily = $font->getFontFamiliesByCategory($category);
	$fontFamilyHTML = '<option value="">Select Font</option>';
	for($i=0;$i<count($fontFamily);$i++) {
		$fontFamilyHTML .= '<option value="' . $fontFamily[$i] . '">' . $fontFamily[$i] . '</option>';
	}	
	echo $fontFamilyHTML;
}

if(isset($_GET['familyForCategory'])) {
	$family = $_GET['familyForCategory'];
	$category = $font->getCategoryByFamily($family);
	echo  $category;
}
