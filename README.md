# Laravel Testing Kit

這個套件整理了一些測試用的 Traits，用來輔助測試。

### 安裝方式

`composer require nox0121/laravel-testing-kit`

### 使用方法

	use Nox0121\LaravelTestingKit\Traits\AssertHttpRequestTrait;

	class ControllerTest extends TestCase
	{
    	use AssertHttpRequestTrait;
    }
