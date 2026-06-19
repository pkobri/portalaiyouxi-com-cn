<?php

/**
 * SiteMeta - 站点元信息管理
 * 
 * 使用数组保存站点元信息，并提供生成简短描述文本的方法。
 * 适用于项目基础配置与展示场景。
 */

class SiteMeta
{
    /**
     * 站点元信息数组
     *
     * @var array
     */
    private array $metaData;

    /**
     * 构造函数，初始化默认元信息
     */
    public function __construct()
    {
        $this->metaData = [
            'site_name'        => '爱游戏门户',
            'site_url'         => 'https://portalaiyouxi.com.cn',
            'site_description' => '爱游戏 - 发现最好玩的游戏世界',
            'site_keywords'    => ['爱游戏', '游戏门户', '游戏推荐', '玩家社区'],
            'site_language'    => 'zh-CN',
            'author'           => '爱游戏团队',
            'version'          => '1.0.0',
            'created_year'     => 2025,
        ];
    }

    /**
     * 设置元信息的值
     *
     * @param string $key   键名
     * @param mixed  $value 值
     * @return void
     */
    public function setMeta(string $key, $value): void
    {
        $this->metaData[$key] = $value;
    }

    /**
     * 获取元信息的值
     *
     * @param string $key 键名
     * @return mixed|null 存在则返回值，否则返回 null
     */
    public function getMeta(string $key)
    {
        return $this->metaData[$key] ?? null;
    }

    /**
     * 生成站点简短描述文本
     *
     * @return string 格式化的描述文本
     */
    public function generateDescription(): string
    {
        $name = $this->escapeHtml($this->metaData['site_name'] ?? '');
        $url  = $this->escapeHtml($this->metaData['site_url'] ?? '');
        $desc = $this->escapeHtml($this->metaData['site_description'] ?? '');
        $kw   = $this->metaData['site_keywords'] ?? [];
        $kwStr = implode(', ', array_map([$this, 'escapeHtml'], $kw));

        $parts = [];
        if ($name) {
            $parts[] = $name;
        }
        if ($desc) {
            $parts[] = $desc;
        }
        if ($url) {
            $parts[] = "官网: {$url}";
        }
        if ($kwStr) {
            $parts[] = "关键词: {$kwStr}";
        }

        return implode(' | ', $parts);
    }

    /**
     * 获取完整的元信息数组
     *
     * @return array
     */
    public function getAllMeta(): array
    {
        return $this->metaData;
    }

    /**
     * 将站点元信息输出为 HTML meta 标签（示例用途）
     *
     * @return string HTML 字符串
     */
    public function toHtmlMetaTags(): string
    {
        $html = '';
        $html .= '<meta charset="' . $this->escapeHtml($this->metaData['site_language'] ?? 'utf-8') . "\">\n";
        $html .= '<meta name="description" content="' . $this->escapeHtml($this->metaData['site_description'] ?? '') . "\">\n";
        $html .= '<meta name="keywords" content="' . $this->escapeHtml(implode(', ', $this->metaData['site_keywords'] ?? [])) . "\">\n";
        $html .= '<meta name="author" content="' . $this->escapeHtml($this->metaData['author'] ?? '') . "\">\n";
        return $html;
    }

    /**
     * 安全转义 HTML 特殊字符
     *
     * @param string $input 输入字符串
     * @return string 转义后的字符串
     */
    private function escapeHtml(string $input): string
    {
        return htmlspecialchars($input, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    /**
     * 重置为默认元信息
     *
     * @return void
     */
    public function resetToDefault(): void
    {
        $this->__construct();
    }
}

// --- 示例用法 ---

// 创建实例
$siteMeta = new SiteMeta();

// 输出简短描述
echo $siteMeta->generateDescription() . "\n";

// 输出 HTML meta 标签示例
echo $siteMeta->toHtmlMetaTags();

// 自定义设置
$siteMeta->setMeta('site_description', '爱游戏 - 汇聚精品游戏，畅享无限乐趣');
echo $siteMeta->generateDescription() . "\n";