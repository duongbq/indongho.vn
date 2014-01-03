<?php
class Sitemap_Model extends CI_Model
{
    function  __construct()
    {
        parent::__construct();
        $this->load->helper('commons');
    }

    /**
     * Tao ra danh sach 50 posts moi nhat
     */
    private function _generate_latest_posts($number_of_post=500)
    {
        $today  = date('Y-m-d');
        $output = '';
        $query =
        $this->db->select('products.id, products.product_name, products.categories_id, categories.category, product_images.position, product_images.image_name, products.lang')
                            ->join('categories', 'products.categories_id = categories.id', 'left')
                            ->join('product_images', 'products.id = product_images.products_id', 'left')
                            ->where('status', ACTIVE_PRODUCT)
                            ->where('((product_images.position=1) OR (product_images.image_name <> NULL))')
                            ->limit($number_of_post) // gioi han chi lay 200 ban ghi moi nhat
                            ->order_by('updated_date', 'DESC')
                            ->get('products');
        $products  = $query->result();
        foreach($products as $product)
        {
            $loc            = get_base_url($product->lang);
            $loc            .= url_title($product->category, 'dash', TRUE) . '-c' . $product->categories_id .'/'  . get_uri_product($product->product_name, $product->id);
            $output .= <<<EOB
<url>
    <loc>{$loc}</loc>
    <lastmod>{$today}</lastmod>
    <changefreq>weekly</changefreq>
</url>

EOB;
        }
        return $output;
    }

    private function _generate_categories_subs()
    {
        $today  = date('Y-m-d');
        $output = '';
        $query = $this->db->get('categories');
        $categories = $query->result();

        foreach($categories as $category)
        {
            $loc            = get_base_url($category->lang). url_title($category->category, 'dash', TRUE) . '-c' . $category->id;
            $output .= <<<EOB
<url>
    <loc>{$loc}</loc>
    <lastmod>{$today}</lastmod>
    <changefreq>daily</changefreq>
</url>

EOB;
        }
        return $output;
    }
    
    private function _generate_latest_news($number_of_post=500)
    {
        $today  = date('Y-m-d');
        $output = '';
        $this->db->select(' news.id,
                            news.title,
                            news.summary,
                            news.created_date,
                            news.cat_id,
                            news_categories.category,
                            news.lang
                        ');

        $this->db->join('news_categories', 'news_categories.id = news.cat_id', 'left');
        $this->db->order_by('news.created_date desc');
        $query = $this->db->get('news');
        $news  = $query->result();
        foreach($news as $new)
        {
            $loc            = get_base_url($new->lang);
            $loc            .= url_title(trim($new->category), 'dash', TRUE) . '/' . url_title(trim($new->title), 'dash', TRUE) . '-n' . $new->cat_id . '-' . $new->id;
            
            $output .= <<<EOB
<url>
    <loc>{$loc}</loc>
    <lastmod>{$today}</lastmod>
    <changefreq>weekly</changefreq>
</url>

EOB;
        }
        return $output;
    }
    
    private function _generate_news_categories()
    {
        $today  = date('Y-m-d');
        $output = '';
        $query = $this->db->get('news_categories');
        $categories = $query->result();

        foreach($categories as $category)
        {
            $loc            = get_base_url($category->lang). url_title($category->category, 'dash', TRUE) . '-n' . $category->id;
            $output .= <<<EOB
<url>
    <loc>{$loc}</loc>
    <lastmod>{$today}</lastmod>
    <changefreq>daily</changefreq>
</url>

EOB;
        }
        return $output;
    }

    function generate_sitemap()
    {
        $output = '';
        $today = date('Y-m-d');
        $domain = DOMAIN_NAME;
        $output = <<<EOB
<?xml version="1.0" encoding="UTF-8"?>
<urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
<url>
    <loc>{$domain}</loc>
    <lastmod>{$today}</lastmod>
    <changefreq>daily</changefreq>
</url>
EOB;
        $output .= $this->_generate_latest_posts();
        $output .= $this->_generate_categories_subs();
        $output .= $this->_generate_latest_news();
        $output .= $this->_generate_news_categories();
        $output .= '</urlset>';

        return $output;
    }
}
?>