<?php

namespace KayStrobach\Themes\Frontend;
use TYPO3\CMS\Core\TypoScript\Parser\TypoScriptParser;
use TYPO3\CMS\Core\Utility\DebugUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class EditorController
 *
 * @package KayStrobach\Themes\Frontend
 */
class CssClassMapper {

	public function mapGenericToFramework($content, $conf) {
		$genericClasses = array_flip(GeneralUtility::trimExplode(',', $content));
		foreach($conf as $checkConfKey => $checkConfValue) {
			if(is_array($conf[$checkConfValue])) {
				continue;
			} else if ($checkConfValue && strpos($checkConfValue, '<') === 0) {
				$checkConfValue = ltrim($checkConfValue, '< lib.') . '.';
				$conf[$checkConfKey] = $GLOBALS['TSFE']->tmpl->setup['lib.'][$checkConfValue];
			}
		}
		$frameworkClasses = array_merge($conf['allClassMapping'], $conf['behaviourClassMapping'], $conf['rowClassMapping'], $conf['columnClassMapping']);
		$mappedClasses = array_intersect_key($frameworkClasses, $genericClasses);
		return implode(' ', $mappedClasses);
	}

}