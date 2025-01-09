<?php

namespace SocolaDaiCa\LaravelModulesCommand\PhpParse;

use Illuminate\Support\Arr;
use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Namespace_;
use PhpParser\ParserFactory;
use SocolaDaiCa\LaravelModulesCommand\PhpParse\PrettyPrinter\Standard;
use Stringable;

class PhpParse implements Stringable
{
    protected Namespace_ $ast;

    protected \PhpParser\Lexer\Emulative $lexer;

    protected \PhpParser\Parser $parser;

    /**
     * @var Node[]
     */
    protected array $newStmts;

    protected array $oldTokens;

    protected Standard $printer;

    /**
     * @var Node\Stmt[]|null
     */
    protected ?array $oldStmts;

    protected \PhpParser\NodeTraverser $traverser;

    protected PhpParseFactory $phpParseFactory;

    public function __construct()
    {
        $this->parser = (new ParserFactory())->createForNewestSupportedVersion();

        $this->traverser = new \PhpParser\NodeTraverser();
        $this->traverser->addVisitor(new \PhpParser\NodeVisitor\CloningVisitor());

        $this->printer = new Standard();
    }

    public function parseAst($code)
    {
        $this->oldStmts = $this->parser->parse($code);

        // $this->traverser->addVisitor(new class extends NodeVisitorAbstract {
        //     public function leaveNode(Node $node) {
        //         if ($node instanceof Class_) {
        //             $node->setAttributes([]);
        //             // $factory = new \PhpParser\BuilderFactory();
        //             /** @var \PhpParser\Node\Stmt\Class_ $node */
        //             /** @var ClassMethod $method */
        //             // $method = $factory
        //             //     ->method('using')
        //             //     ->makeStatic()
        //             //     ->addStmt(new Node\Stmt\Return_(
        //             //         new Node\Expr()
        //             //     ))
        //             //     ->getNode()
        //             // ;
        //             //     public static function using()
        //             //     {
        //             //         return static::class . \':\' . implode(\',\', func_get_args());
        //             //     }
        //             // $node->stmts[] = $method;
        //             return $node;
        //             // return true;
        //         }
        //         // if ($node instanceof Node\Scalar\LNumber) {
        //         //     return new Node\Scalar\String_((string) $node->value);
        //         // }
        //     }
        // });

        $this->newStmts = $this->traverser->traverse($this->oldStmts);

        $this->phpParseFactory = app(PhpParseFactory::class);

        return $this;
    }

    public function parse($code)
    {
        return $this->parser->parse($code)[0];
    }

    public function parseRawCode($code)
    {
        return $this->parser->parse("<?php \n".$code);
    }

    public function getAst()
    {
        return $this->newStmts[0];
    }

    public function getNewStmts(): array
    {
        return $this->newStmts;
    }

    public function class(): Class_
    {
        return Arr::last($this->getAst()->stmts);
    }

    public function method($methodName): ClassMethod
    {
        return Arr::first(
            $this->class()->stmts,
            fn (ClassMethod $classMethod) => $classMethod->name->name == $methodName,
        );
    }

    public function addMethod($code)
    {
        /** @var ClassMethod $method */
        $method = $this->phpParseFactory->makeMethod($code);
        $this->class()->stmts[] = new Node\Stmt\Nop();
        $this->class()->stmts[] = $method;

        return $this;
    }

    public function addAttribute()
    {
    }

    public function __toString(): string
    {
        $this->oldTokens = $this->parser->getTokens();

        return $this->printer->printFormatPreserving(
            $this->newStmts,
            $this->oldStmts,
            $this->oldTokens,
        );
    }
}
