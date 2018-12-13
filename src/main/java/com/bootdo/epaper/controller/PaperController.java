package com.bootdo.epaper.controller;

import com.bootdo.common.utils.DateUtils;
import com.bootdo.common.utils.PageUtils;
import com.bootdo.common.utils.Query;
import com.bootdo.common.utils.R;
import com.bootdo.epaper.domain.PaperDO;
import com.bootdo.epaper.service.PaperService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.*;

import java.util.HashMap;
import java.util.List;
import java.util.Map;

/**
 * 
 * 
 * @author hzw
 * @email hao17681124518@163.com
 * @date 2018-12-11 21:48:48
 */
 
@Controller
@RequestMapping("/epaper/paper")
public class PaperController {
	@Autowired
	private PaperService paperService;
	
	@GetMapping()
//	@RequiresPermissions("epaper:paper:paper")
	String Paper(Model model){
	    //期数默认
		int publishid = paperService.getLastPublishID()+1;
		model.addAttribute("publishid",publishid);
		return "epaper/Admin/AddPeriodical";
	}

	@GetMapping("/hotManage")
//	@RequiresPermissions("epaper:paper:hotmanage")
	String hotManage(Model model){
		//期数默认
		int publishid = paperService.getLastPublishID()+1;
		model.addAttribute("publishid",publishid);
		return "epaper/Admin/HotManage";
	}
	
	@ResponseBody
	@GetMapping("/list")
//	@RequiresPermissions("epaper:paper:paper")
	public PageUtils list(@RequestParam Map<String, Object> params){
		//查询列表数据
        Query query = new Query(params);
		List<PaperDO> paperList = paperService.list(query);
		int total = paperService.count(query);
		PageUtils pageUtils = new PageUtils(paperList, total);
		return pageUtils;
	}
	
	@GetMapping("/add")
//	@RequiresPermissions("epaper:paper:add")
	String add(Model model){
		//期数默认
		int publishid = paperService.getLastPublishID()+1;
		model.addAttribute("publishid",publishid);
	    return "epaper/Admin/HotManage_Add";
	}

	@GetMapping("/edit/{id}")
//	@RequiresPermissions("epaper:paper:edit")
	String edit(@PathVariable("id") Long id,Model model){
		PaperDO paper = paperService.get(id);
		model.addAttribute("paper", paper);
	    return "epaper/Admin/HotManage_Edit";
	}
	
	/**
	 * 保存
	 */
	@ResponseBody
	@PostMapping("/save")
//	@RequiresPermissions("epaper:paper:add")
	public R save( PaperDO paper){
		//校验该日期的报纸是否已添加
		Map<String,Object> parMap = new HashMap<String,Object>();
//		String publishdate = DateUtils.format(paper.getPublishdate(),"yyyy-MM-dd");
		parMap.put("publishdate",paper.getPublishdate());
		int count = paperService.count(parMap);
		if(count>0){
			return R.error().put("msg","已添加"+paper.getPublishdate()+"的报纸，请勿重复添加！");
		}
		if(paperService.save(paper)>0){
			return R.ok().put("msg","期刊添加成功！");
		}
		return R.error();
	}
	/**
	 * 修改
	 */
	@ResponseBody
	@RequestMapping("/update")
//	@RequiresPermissions("epaper:paper:edit")
	public R update( PaperDO paper){
		paperService.update(paper);
		return R.ok();
	}
	
	/**
	 * 删除
	 */
	@PostMapping( "/remove")
	@ResponseBody
//	@RequiresPermissions("epaper:paper:remove")
	public R remove( Long id){
		if(paperService.remove(id)>0){
		return R.ok();
		}
		return R.error();
	}
	
	/**
	 * 删除
	 */
	@PostMapping( "/batchRemove")
	@ResponseBody
//	@RequiresPermissions("epaper:paper:batchRemove")
	public R remove(@RequestParam("ids[]") Long[] ids){
		paperService.batchRemove(ids);
		return R.ok();
	}
	
}
