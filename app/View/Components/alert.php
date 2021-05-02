<?php

namespace App\View\Components;

use Illuminate\View\Component;

class alert extends Component
{
    /**
     * 警告タイプ
     *
     * @var string
     */
    public $type;

    /**
     * 警告メッセージ セッション
     *
     * @var string
     */
    public $session;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type, $session)
    {
        $this->type = $type;
        $this->session = $session;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.alert');
    }
}
