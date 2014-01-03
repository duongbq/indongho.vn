<?php
class News_Model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function get_news($options = array())
    {
        $this->db->select(' news.id,
                            news.title,
                            news.summary,
                            news.content,
                            news.created_date,
                            news.viewed,
                            news.cat_id,
                            news.thumbnail,
                            news.cat_id as categories_id,
                            news.meta_title,
                            news.meta_keywords,
                            news.meta_description,
                            news.tags,
                            news.lang,
                            news_categories.meta_keywords cat_meta_keywords,
                            news_categories.parent_id,
                            news_categories.category,
                        ');

        $this->db->join('news_categories', 'news_categories.id = news.cat_id', 'left');

        // lọc ngôn ngữ
        if(isset($options['lang']))
        {
            $this->db->where('news.lang', $options['lang']);
        }
        
        // chi lay nhung news moi nhat
        if (isset($options['flag']) && $options['flag']==LATEST_NEWS)
        {
            $this->db->where('news.created_date >\'' . $options['created_date'] . '\'');
            unset($options['id']); // loai bo id
        }

        if (isset($options['id']))
            if (isset($options['flag']) && $options['flag']==OLDER_NEWS)
                $this->db->where('news.created_date <\'' . $options['created_date'] . '\'');
            else
                $this->db->where('news.id', $options['id']);

        // neu chon parent category thi se hien tat
        if (isset($options['cat_id']) && $options['cat_id'] != DEFAULT_COMBO_VALUE)//@duongbq added: 2011-05-23
            $this->db->where('cat_id = ' . $options['cat_id']);
        
        // Tim kiem
        if (isset($options['search']))
        {
            $where  = "(title like'%" . $options['search'] . "%'";
            $where .= " or content like'%" . $options['search'] . "%'";
            $where .= " or summary like'%" . $options['search'] . "%')";
            $this->db->where($where);
        }
        if(isset($options['except_id']))
            $this->db->where('news.id !=', $options['except_id']);
        
        // Loc theo trang
        if (isset($options['limit']) && isset($options['offset']))
            $this->db->limit($options['limit'], $options['offset']);
        else if (isset($options['limit']))
            $this->db->limit($options['limit']);

        $this->db->order_by('news.created_date desc');

        $query = $this->db->get('news');

        if (isset($options['id']))
            if (!isset($options['flag']))
                return $query->row(0);
        return $query->result();
    }

    public function get_news_count($options = array())
    {
        return count($this->get_news($options));
    }

    function add_news($post_data = array())
    {
        $this->db->insert('news', $post_data);
    }

    function update_news($post_data = array())
    {
        $this->db->where('id', $post_data['id']);
        $this->db->update('news', $post_data);
    }

    function delete_news($id = 0)
    {
        $this->db->where('id', $id);
        $this->db->delete('news');
    }

    public function update_view($id = 0)
    {
        $this->db->set('viewed', 'viewed + 1', FALSE);
        $this->db->where('id', $id);
        $this->db->update('news');
    }
}
?>