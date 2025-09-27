<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    public function definition(): array
    {
        return [
            'last_name' => $this->faker->lastName,
            'first_name' => $this->faker->firstName,
            'gender' => $this->faker->randomElement(['male', 'female', 'other']),
            'email' => $this->faker->unique()->safeEmail,
            'tel1' => $this->faker->numberBetween(2, 9999),
            'tel2' => $this->faker->numberBetween(10, 9999),
            'tel3' => $this->faker->numberBetween(1000, 9999),
            'address' => $this->faker->address,
            'building' => $this->faker->optional()->secondaryAddress,

            // カテゴリ（外部キーよりランダムに選ぶ）
            'category_id' => Category::inRandomOrder()->first()->id ?? 1,

            // 問い合わせ内容
            'content' => $this->faker->randomElement(['商品がまだ届いていません。確認をお願いします。', '商品のサイズを交換したいです。', '注文した商品に不具合がありました。', '支払い方法について教えてください。', 'その他の質問があります。']),
        ];
    }
}
