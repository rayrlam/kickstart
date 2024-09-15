<?php

namespace Tests\Unit\PHP;

use Tests\Unit\PHP\ParentClass;

class ChildClass extends ParentClass {
    #[Override]
    public function doSomething() {
        return "Child method";
    }
}