<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Noticeinfo;

/**
 * Noticelist represents the model behind the search form about `app\models\Noticeinfo`.
 */
class Noticelist extends Noticeinfo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['announce_id', 'type', 'comment_switch','confirmNum'], 'integer'],
            [['title', 'content', 'attach', 'sender', 'enterpris_id', 'sender_name','time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        if(isset($params['Noticelist']['time'])){
      //       $params['Noticelist']['time'] = strtotime($params['Noticelist']['time']);   
        }
  //      print_r($params);
        $query = Noticeinfo::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        //$params['Noticelist']['title']='11';
        //print_r($params['Noticelist']);
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'announce_id' => $this->announce_id,
            'type' => $this->type,
            'comment_switch' => $this->comment_switch,
           // 'time' => $this->time,
            'confirmNum' => $this->confirmNum,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'attach', $this->attach])
            ->andFilterWhere(['like', 'sender', "@".Yii::$app->session['user.eid']])
            ->andFilterWhere(['like', 'enterpris_id', $this->enterpris_id])
            ->andFilterWhere(['>', 'time', $this->time?strtotime($this->time." 00:00:00"):""])
            ->andFilterWhere(['<', 'time', $this->time?strtotime($this->time." 23:59:59"):""])
            ->andFilterWhere(['like', 'sender_name', $this->sender_name]);
        if(!isset($params['sort'])){
            $dataProvider->query->orderBy=['comment_switch' => SORT_DESC,'time' => SORT_DESC];
        }
    //    print_r($dataProvider->query);

        return $dataProvider;
    }
}
